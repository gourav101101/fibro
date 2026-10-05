// Record original canvas diagrams as short, silent WebM clips with native controls.
// Requires a local Chromium debugging endpoint, never a remote browser.
import fs from 'node:fs/promises';
import sharp from 'sharp';
const pages = await (await fetch('http://127.0.0.1:9333/json')).json();
const page = pages.find(item => item.type === 'page');
const socket = new WebSocket(page.webSocketDebuggerUrl);
await new Promise(resolve => socket.addEventListener('open', resolve, {once:true}));
let counter = 0;
const pending = new Map();
socket.addEventListener('message', event => {
  const message = JSON.parse(event.data);
  if (pending.has(message.id)) { pending.get(message.id)(message); pending.delete(message.id); }
});
function call(method, params) { return new Promise(resolve => { const id = ++counter; pending.set(id, resolve); socket.send(JSON.stringify({id,method,params})); }); }

async function record(kind) {
  const canvas = document.createElement('canvas'); canvas.width = 1280; canvas.height = 720;
  document.body.replaceChildren(canvas);
  const ctx = canvas.getContext('2d');
  const line = (points, color, width = 5) => { ctx.strokeStyle=color; ctx.lineWidth=width; ctx.lineCap='round'; ctx.beginPath(); points.forEach(([x,y],i) => i ? ctx.lineTo(x,y) : ctx.moveTo(x,y)); ctx.stroke(); };
  const text = (value,x,y,size=24,color='#263b4d') => { ctx.font=`${size}px Arial`; ctx.fillStyle=color; ctx.fillText(value,x,y); };
  const arrow = (x,y,color) => line([[x-9,y+12],[x,y],[x+9,y+12]],color,4);
  const round = (x,y,w,h,color) => {ctx.fillStyle=color;ctx.beginPath();ctx.roundRect(x,y,w,h,16);ctx.fill();};
  function draw(time) {
    ctx.fillStyle='#f7f4ed';ctx.fillRect(0,0,1280,720);
    text('FIBRO  /  MATERIAL EXPLAINER',60,55,18,'#677363');
    text(kind === 'circular' ? 'Materials with another chapter.' : 'Protection above. Comfort beneath.',60,115,42);
    if (kind === 'circular') {
      const names=['Collect & sort','Recover fibres','Make fabric','Use & care'];
      const descriptions=['Separate suitable inputs','Process recovered material','Selected recycled inputs','Keep products in use'];
      for(let i=0;i<4;i++) {
        const x=60+i*305, active=Math.floor(time/2)%4 === i;
        round(x,230,265,230,active?'#c9d9bd':'#e7ecdf');
        text(`0${i+1}`,x+24,278,22,'#597647');text(names[i],x+24,338,27);text(descriptions[i],x+24,388,17);
        if(i<3) { line([[x+273,345],[x+293,345]],'#597647',4); line([[x+285,337],[x+293,345],[x+285,353]],'#597647',4); }
      }
      line([[1110,480],[1110,525],[185,525],[185,480]],'#8b9d7e',3);
      const x=1110-925*((time%8)/8);ctx.beginPath();ctx.arc(x,525,8,0,Math.PI*2);ctx.fillStyle='#557544';ctx.fill();
      text('Recycled inputs and recyclable design are distinct.',60,595,25);
      text('Recycling depends on material compatibility, collection and available facilities.',60,635,21,'#687466');
    } else {
      ctx.fillStyle='#dfb655';ctx.beginPath();ctx.arc(145,220,42,0,Math.PI*2);ctx.fill();
      ctx.fillStyle='#b9c4c6';ctx.beginPath();ctx.moveTo(260,500);ctx.lineTo(305,340);ctx.quadraticCurveTo(660,230,1015,340);ctx.lineTo(1060,500);ctx.closePath();ctx.fill();
      line([[375,515],[375,435],[940,435],[940,515]],'#354d5a',18);line([[400,515],[400,550]],'#354d5a',14);line([[915,515],[915,550]],'#354d5a',14);
      for(let i=0;i<4;i++) {
        const x=330+i*165;
        ctx.setLineDash([18,12]);ctx.lineDashOffset=-time*35;
        line([[x-60,195],[x,300],[x+75,190]],'#c89927',5);ctx.setLineDash([]);arrow(x+75,190,'#c89927');
        const progress=(time/3+i/4)%1, y=510-progress*205;ctx.globalAlpha=Math.sin(progress*Math.PI);
        line([[x+40,y+65],[x+40,y]],'#b96a48',5);arrow(x+40,y,'#b96a48');ctx.globalAlpha=1;
      }
      text('UV protection',60,595,26,'#967020');text('Heat & moisture release',690,595,26,'#a75a3c');
      text('Illustrative behaviour: fabric selection, cover design and ventilation affect performance.',60,640,21,'#687466');
    }
    text('Concept illustration — not a performance test or a guaranteed recycling route.',60,689,16,'#738074');
  }
  draw(0);
  const poster=canvas.toDataURL('image/png').split(',')[1];
  const stream=canvas.captureStream(24);
  const mime='video/webm;codecs=vp9';
  const recorder=new MediaRecorder(stream,{mimeType:MediaRecorder.isTypeSupported(mime)?mime:'video/webm',videoBitsPerSecond:2200000});
  const chunks=[];recorder.ondataavailable=e=>chunks.push(e.data);
  const complete=new Promise(resolve=>recorder.onstop=resolve);
  recorder.start(); const start=performance.now();
  const timer=setInterval(()=>draw((performance.now()-start)/1000),1000/24);
  await new Promise(resolve=>setTimeout(resolve,10000)); clearInterval(timer);recorder.stop();await complete;stream.getTracks().forEach(track=>track.stop());
  const blob=new Blob(chunks,{type:'video/webm'});
  const video=await new Promise(resolve=>{const reader=new FileReader();reader.onload=()=>resolve(reader.result.split(',')[1]);reader.readAsDataURL(blob);});
  return {poster,video};
}
await fs.mkdir('public/video', {recursive:true});
for (const kind of ['circular','outdoor']) {
  const result=await call('Runtime.evaluate',{expression:`(${record.toString()})(${JSON.stringify(kind)})`,awaitPromise:true,returnByValue:true});
  if(result.result?.exceptionDetails || !result.result?.result?.value) throw new Error(JSON.stringify(result));
  const {poster,video}=result.result.result.value;
  await fs.writeFile(`public/video/fibro-${kind}-explainer.webm`,Buffer.from(video,'base64'));
  await sharp(Buffer.from(poster,'base64')).webp({quality:85}).toFile(`public/video/fibro-${kind}-poster.webp`);
  console.log(`Saved ${kind} video and poster.`);
}
socket.close();
