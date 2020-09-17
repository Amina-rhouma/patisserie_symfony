const deleteButtons = document.querySelectorAll('table .delete-button');
addListenerToDeleteButton(deleteButtons);

const scripts = document.getElementsByTagName('script');
const lastScript = scripts[scripts.length - 1];
const cakeType = lastScript.dataset.cakeType;
const verrineType = lastScript.dataset.verrineType;

function addListenerToDeleteButton(elementLists) {
  elementLists.forEach(function (element) {
    element.addEventListener("click", function(event) {
      event = event || window.event;
      event.preventDefault();

      var target = event.target || event.srcElement;

      while (target) {
        if (target instanceof HTMLAnchorElement) {

          const productId = target.dataset.productId;
          const productType = target.dataset.productType;

          deleteProduct(productId, productType);
          break;
        }

        target = target.parentNode;
      }
    });
  });
}

function buildDeleteUrl(productId, productType) {
  let url = "/produits";
  if (productType == cakeType) {
    url = url + "/gateaux";
  } else if (productType == verrineType) {
    url = url + "/verrines";
  }
  return url + "/" + productId;
}

function deleteProduct(productId, productType) {

  const url = buildDeleteUrl(productId, productType);

  axios
    .delete(
      url,
      {
        withCredentials: true
      }
    ).then(function () {
      location.reload();
    })
    .catch(function (error) {
      console.log(error);
    });
}
