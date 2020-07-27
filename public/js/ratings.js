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
      const dataJson = JSON.parse(response.data);
      currentRating = parseFloat(dataJson["newRating"]);
      renderRatings(currentRating);
    });
}

function addRatingsListenerToStars(productId, productType) {
  images.forEach(function (element, index) {
    element.addEventListener("click", function() {
      saveRating(productId, productType, index + 1);
    });
  });
}

function addHoverListenerToStars() {
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
      renderRatings(currentRating)
    });
  });
}

function renderRatings(rating) {
  repartition = [];

  full = Math.floor(rating);
  half = Math.round(rating - full);
  empty = 5 - full - half;

  repartition["full"] = full; // 3
  repartition["half"] = half; // 1
  repartition["empty"] = empty; // 1

  for (let i = 0; i < full; i++) {
    images[i].src = fullStar;
  }

  for (let i = full; i < full + half; i++) {
    images[i].src = halfStar;
  }

  for (let i = full + half; i < full + half + empty; i++) {
    images[i].src = emptyStar;
  }
}