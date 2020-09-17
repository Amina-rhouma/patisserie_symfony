const images = document.querySelectorAll('.ratings img');

const scripts = document.getElementsByTagName('script');
const lastScript = scripts[scripts.length - 1];
const emptyStar = lastScript.dataset.emptyStarIcon;
const halfStar = lastScript.dataset.halfStarIcon;
const fullStar = lastScript.dataset.fullStarIcon;

let currentRating = lastScript.dataset.avgRatings;
let productId = lastScript.dataset.productId;
let productType = lastScript.dataset.productType;

renderRatings(lastScript.dataset.avgRatings);
addRatingsListenerToStars(productId, productType);
addHoverListenerToStars();

/**
 *
 * cette fonction envoi au backend les nouvelles valeurs du vote
 * pour le produit productId.
 *
 * @param productId l'identifiant du produit
 * @param productType le type de produit(cake/verrine)
 * @param rating le nouveau vote de cet utilisateur pour ce produit
 */
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

/**
 * ajoute un listener au icons etoiles
 * @param productId l'identifiant du produit
 * @param productType le type de produit(cake/verrine)
 */
function addRatingsListenerToStars(productId, productType) {
  images.forEach(function (element, index) {
    element.addEventListener("click", function() {
      saveRating(productId, productType, index + 1);
    });
  });
}

/**
 * change les images de l'etoile au survol de la souris
 */
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

/**
 * affiche les images des images etoiles correspondantes
 * au rating passé en parametre
 * @param rating
 */
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