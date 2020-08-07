function addListenerToDeleteButton(elementLists) {
  elementLists.forEach(function (element) {
    element.addEventListener("click", function(event) {

      event.preventDefault();
      const productId = event.target.dataset.productId;
      const productType = event.target.dataset.productType;

      deleteProduct(productId, productType);

    });
  });
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
