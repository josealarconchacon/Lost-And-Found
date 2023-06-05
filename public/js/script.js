const btnHide = document.getElementById("toggler-btn");
const btnShow = document.getElementById("toggler-btn-close");

btnHide.addEventListener("click", () => {
  if (btnHide.style.visibility !== "hidden") {
    btnHide.style.visibility = "hidden";
  } else {
    btnHide.style.visibility = "visible";
  }
});

btnShow.addEventListener("click", () => {
  if (btnShow.style.visibility !== "hidden") {
    btnHide.style.visibility = "visible";
  } else {
    btnShow.style.visibility = "visible";
  }
});

const openNav = () => {
  document.getElementById("mySidenav").style.width = "350px";
  document.getElementById("main").style.marginLeft = "350px";
  document.body.style.backgroundColor = "rgb(245, 245, 245)";
};

const closeNav = () => {
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById("main").style.marginLeft = "0";
  document.body.style.backgroundColor = "white";
};
