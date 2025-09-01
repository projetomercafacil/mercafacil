function toggleMenu(){}

function applyThemeFromStorage(){
  const saved = localStorage.getItem('theme');
  if(saved === 'dark'){ document.body.classList.add('dark'); }
  updateThemeButton();
}
function toggleTheme(){
  document.body.classList.toggle('dark');
  localStorage.setItem('theme', document.body.classList.contains('dark') ? 'dark' : 'light');
  updateThemeButton();
}
function updateThemeButton(){
  const btn = document.getElementById('themeBtn');
  if(!btn) return;
  const dark = document.body.classList.contains('dark');
  btn.textContent = dark ? '☀️' : '🌙';
  btn.title = dark ? 'Modo claro' : 'Modo escuro';
}
document.addEventListener('DOMContentLoaded', applyThemeFromStorage);

/* Scanner com BarcodeDetector API */
async function startScanner(){
  const video = document.getElementById('cam');
  if(!video) return;

  if ('BarcodeDetector' in window) {
    try{
      const stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' }});
      video.srcObject = stream; video.style.display='block'; await video.play();

      const detector = new window.BarcodeDetector({ formats: ['qr_code','ean_13','code_128','upc_e','ean_8'] });
      let running = true;

      const tick = async () => {
        if(!running) return;
        try{
          const codes = await detector.detect(video);
          if(codes && codes.length){
            const code = codes[0].rawValue;
            // preenche e envia
            const input = document.getElementById('manualCode');
            input.value = code;
            running = false;
            // para a câmera
            stream.getTracks().forEach(t=>t.stop());
            // envia o form
            input.closest('form').submit();
            return;
          }
        }catch(e){}
        requestAnimationFrame(tick);
      };
      tick();
    }catch(err){
      alert('Não foi possível acessar a câmera. Use a digitação manual do código.');
    }
  } else {
    alert('Seu navegador não suporta leitura de código. Use a digitação manual.');
  }
}

document.addEventListener('DOMContentLoaded', ()=>{
  const btn = document.getElementById('btnScan');
  if(btn){ btn.addEventListener('click', startScanner); }
});
