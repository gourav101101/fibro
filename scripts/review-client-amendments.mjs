import fs from 'node:fs/promises';
const pages=await (await fetch('http://127.0.0.1:9333/json')).json();
const socket=new WebSocket(pages.find(p=>p.type==='page').webSocketDebuggerUrl);
await new Promise(resolve=>socket.addEventListener('open',resolve,{once:true}));
let id=0;const pending=new Map();
socket.addEventListener('message',e=>{const m=JSON.parse(e.data);if(pending.has(m.id)){pending.get(m.id)(m);pending.delete(m.id);}});
function call(method,params={}){return new Promise(resolve=>{const next=++id;pending.set(next,resolve);socket.send(JSON.stringify({id:next,method,params}));});}
async function evaluate(expression){const r=await call('Runtime.evaluate',{expression,awaitPromise:true,returnByValue:true,userGesture:true});if(r.result.exceptionDetails)throw new Error(JSON.stringify(r.result.exceptionDetails));return r.result.result.value;}
await call('Page.enable');
await fs.mkdir('storage/app/client-source-review',{recursive:true});
for(const width of (process.argv.includes('--video-only') ? [] : [1440,390])) {
 await call('Emulation.setDeviceMetricsOverride',{width,height:950,deviceScaleFactor:1,mobile:false});
 for(const path of ['/products','/products/blackout-curtains','/products/outdoor-furniture-covers','/circular-textiles','/technology']) {
  await call('Page.navigate',{url:`http://127.0.0.1:8013${path}`});
  await new Promise(resolve=>setTimeout(resolve,1800));
  if(path==='/technology') await evaluate(`Array.from(document.querySelectorAll('button')).find(b=>b.textContent.includes('Bring layers together'))?.click()`);
  const state=await evaluate(`({title:document.title,overflow:document.documentElement.scrollWidth>innerWidth,images:Array.from(document.images).filter(i=>i.complete&&!i.naturalWidth).map(i=>i.src),text:document.body.innerText.slice(0,130)})`);
  console.log(width,path,JSON.stringify(state));
  if(state.overflow||state.images.length||/Server Error/.test(state.title))throw new Error('Page review failed');
  const shot=await call('Page.captureScreenshot',{format:'png',captureBeyondViewport:false});
  await fs.writeFile(`storage/app/client-source-review/${width}-${path.replaceAll('/','_')}.png`,Buffer.from(shot.result.data,'base64'));
 }
}
// Verify playback and animation semantics in the browser.
await evaluate(`location.href='http://127.0.0.1:8013/circular-textiles'`);
await new Promise(resolve=>setTimeout(resolve,1200));
console.log('Video',await evaluate(`(async()=>{const v=document.querySelector('video');v.closest('details').open=true;await v.play();await new Promise(r=>setTimeout(r,700));const result={playing:!v.paused,currentTime:v.currentTime,width:v.videoWidth};v.pause();return result;})()`));
await call('Page.navigate',{url:'http://127.0.0.1:8013/technology'});
await new Promise(resolve=>setTimeout(resolve,1200));
await evaluate(`Array.from(document.querySelectorAll('button')).find(b=>b.textContent.includes('Bring layers together')).click()`);
await evaluate(`document.querySelector('svg[aria-label^="Illustrative three-layer"]').scrollIntoView({block:'center'})`);
await new Promise(resolve=>setTimeout(resolve,700));
const effects=await evaluate(`(()=>{const svg=document.querySelector('svg[aria-label^="Illustrative three-layer"]');const rain=svg.querySelector('[class*="rain"]');const vapour=svg.querySelectorAll('[class*="vapour"]');return {rain:!!rain,vapour:vapour.length,animation:rain&&getComputedStyle(rain).animationName};})()`);
if(!effects.rain||effects.vapour!==3)throw new Error('Bonded performance effects missing');
await evaluate(`Array.from(document.querySelectorAll('button')).find(b=>b.textContent.includes('Pause performance animation')).click()`);
const paused=await evaluate(`getComputedStyle(document.querySelector('svg [class*="rain"]')).animationPlayState`);
if(paused!=='paused')throw new Error('Pause control failed');
await call('Emulation.setEmulatedMedia',{features:[{name:'prefers-reduced-motion',value:'reduce'}]});
const reduced=await evaluate(`getComputedStyle(document.querySelector('svg [class*="rain"]')).animationName`);
if(reduced!=='none')throw new Error('Reduced motion failed');
await call('Emulation.setEmulatedMedia',{features:[]});
console.log('Bonded effects, pause control and reduced motion passed.');
const diagram=await call('Page.captureScreenshot',{format:'png'});
await fs.writeFile('storage/app/client-source-review/bonded-effects.png',Buffer.from(diagram.result.data,'base64'));
socket.close();
