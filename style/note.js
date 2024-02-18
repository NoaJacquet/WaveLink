const stars = document.querySelectorAll(".star");
const valider = document.getElementById("valider");
const hiddenInput = document.getElementById("hiddenInput");

stars.forEach((star) => {
  star.addEventListener("click", selectStars);
});

function selectStars(e) {
  const data = e.target;
  const selectStars = priviousStars(data);
  selectStars.forEach((star) => {
    star.classList.add("selected");
  });
  const unselectStars = nextStars(data);
  unselectStars.forEach((star) => {
    star.classList.remove("selected");
  });
}

function priviousStars(data) {
  let values = [data];
  while ((data = data.previousSibling)) {
    if (data.nodeName === "I") {
      values.push(data);
    }
  }
  hiddenInput.value = values.length;
  return values;
}

function nextStars(data) {
  let values = [data];
  while ((data = data.nextSibling)) {
    if (data.nodeName === "I") {
      values.push(data);
    }
  }
  return values.slice(1, values.length);
}
