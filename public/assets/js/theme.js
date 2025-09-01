(function(){
  const btnSelector = '#themeToggle';
  function apply(saved){
    if(saved === 'dark'){ document.body.classList.add('dark'); }
    else { document.body.classList.remove('dark'); }
    const b = document.querySelector(btnSelector);
    if(b){ b.textContent = document.body.classList.contains('dark') ? '☀️ Modo claro' : '🌙 Modo escuro'; }
  }
  const saved = localStorage.getItem('theme') || 'light';
  document.addEventListener('DOMContentLoaded', function(){
    apply(saved);
    const btn = document.querySelector(btnSelector);
    if(btn){
      btn.addEventListener('click', function(){
        const now = document.body.classList.contains('dark') ? 'light' : 'dark';
        localStorage.setItem('theme', now);
        apply(now);
      });
    }
  });
})();
