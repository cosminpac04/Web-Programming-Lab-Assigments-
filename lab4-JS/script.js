const tag = document.getElementById("draggable-tag");
const dragCount = document.getElementById("drag-count");

let isDragging = false;
let offsetX = 0;
let offsetY = 0;
let count = 0;

tag.addEventListener("mousedown", (e) => {
  isDragging = true;
  offsetX = e.clientX - tag.offsetLeft;
  offsetY = e.clientY - tag.offsetTop;
  tag.style.cursor = "grabbing";
});

document.addEventListener("mousemove", (e) => {
  if (isDragging) {
    tag.style.left = e.clientX - offsetX + "px";
    tag.style.top = e.clientY - offsetY + "px";
  }
});

document.addEventListener("mouseup", () => {
  if (isDragging) {
    count++;
    dragCount.textContent = `Drag Count: ${count}`;
  }
  isDragging = false;
  tag.style.cursor = "grab";
});
