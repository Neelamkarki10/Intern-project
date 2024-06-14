document.addEventListener("DOMContentLoaded", function () {
  const detailsElements = document.querySelectorAll("details");

  detailsElements.forEach((detail) => {
    detail.addEventListener("toggle", function () {
      if (this.open) {
        detailsElements.forEach((otherDetail) => {
          if (otherDetail !== this && otherDetail.open) {
            otherDetail.open = false;
          }
        });
      }
    });
  });
});
