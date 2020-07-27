function saveRating(productId, productType, rating) {
  axios
    .post(
      "/like",
      {
        id_product: productId,
        type_product: productType,
        rating: rating
      },
      {
        withCredentials: true
      }
    )
    .then(function (response) {
      console.log(response);
    });
}

function addRatingsListenerToStars(productId, productType) {
  var images = document.querySelectorAll('.ratings img');

  images.forEach(function (element, index) {
    element.addEventListener("click", function() {
      saveRating(productId, productType, index + 1);
    });
  });
}

function addHoverListenerToStars(emptyStar, fullStar) {
  var images = document.querySelectorAll('.ratings img');

  var etatInitial = Array.from(images).map(function(image) {
    return image.src;
  });

  images.forEach(function (element, index) {
    element.addEventListener("mouseover", function() {
      for (let i = 0; i <= index; i++) {
        images[i].src = fullStar;
      }
      if (index < 4) {
        for (let i = index + 1; i < images.length; i++) {
          images[i].src = emptyStar;
        }
      }
    });
  });

  images.forEach(function (element) {
    element.addEventListener("mouseout", function() {
      for (let i = 0; i < images.length; i++) {
        images[i].src = etatInitial[i];
      }
    });
  });
}