
//mouse wheel using JavaScript
const element = document.querySelector("#cat1");
element.addEventListener('wheel', (event) => {
  event.preventDefault();

  element.scrollBy({
    left: event.deltaY < 0 ? -30 : 30,
  });
});