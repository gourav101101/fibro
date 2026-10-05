import fs from 'node:fs/promises';
// Logo reproduced in ITTA's partnership announcement after its own host failed TLS.
const url = 'https://www.techtextilehub.com/web/image/13838-44eac3e9/Blog%20Post%2019%20cover%20image.webp';
const response = await fetch(url);
if (!response.ok) throw new Error(`ITTA returned ${response.status}`);
await fs.writeFile('public/images/credentials/itta.webp', Buffer.from(await response.arrayBuffer()));
console.log('Saved ITTA association logo.');
