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
// toggle
document.addEventListener('DOMContentLoaded', function () {
  // Select the toggle buttons and content divs
  const toggleButtons = document.querySelectorAll('.toggle-button');
  const toggleContents = document.querySelectorAll('.toggle-content');

  // Loop through each toggle button
  toggleButtons.forEach((button, index) => {
      console.log(`Button ${index}:`, button);  
      console.log(`Content ${index}:`, toggleContents[index]); 
      button.addEventListener('click', () => {
          const content = toggleContents[index];

          content.classList.toggle('hide');

          if (!content.classList.contains('hide')) {
              content.style.transition = 'opacity 0.3s ease-in-out';
              content.style.opacity = '1';
          } else {
              content.style.transition = 'opacity 0.3s ease-in-out';
              content.style.opacity = '0';
          }
      });
  });
});