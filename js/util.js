// Learn this 

  const list = document.getElementById('category-list');
  let isMouseDown = false;
  let startX;
  let scrollLeft;

  list.addEventListener('mousedown', (e) => {
    isMouseDown = true;
    startX = e.pageX - list.offsetLeft;
    scrollLeft = list.scrollLeft;
  });

  list.addEventListener('mouseleave', () => {
    isMouseDown = false;
  });

  list.addEventListener('mouseup', () => {
    isMouseDown = false;
  });

  list.addEventListener('mousemove', (e) => {
    if (!isMouseDown) return;
    e.preventDefault();
    const x = e.pageX - list.offsetLeft;
    const walk = (x - startX) * 3; 
    list.scrollLeft = scrollLeft - walk;
  });

  list.addEventListener('touchstart', (e) => {
    isMouseDown = true;
    startX = e.touches[0].pageX - list.offsetLeft;
    scrollLeft = list.scrollLeft;
  });

  list.addEventListener('touchend', () => {
    isMouseDown = false;
  });

  list.addEventListener('touchmove', (e) => {
    if (!isMouseDown) return;
    e.preventDefault();
    const x = e.touches[0].pageX - list.offsetLeft;
    const walk = (x - startX) * 3; 
    list.scrollLeft = scrollLeft - walk;
});

