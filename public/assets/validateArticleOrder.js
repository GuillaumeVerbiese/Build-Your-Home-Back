const validateArticleOrder = {
    buttonList: null,
    init: function() {
      console.log("init");
      // On récupére tous les boutons ".validateButton"
      const buttonList = document.querySelectorAll('.validateButton');
      validateArticleOrder.buttonList = buttonList;
      // On boucle sur la liste pour renseigner la bonne classe et valeur en fonction de data-validate et poser un écouteur sur chacun d'entre eux
      for (const button of buttonList) {
        validateArticleOrder.bindButton(button);
        button.addEventListener('click',validateArticleOrder.handleButtonClicked);
      };
      // On récupére le bouton du form pour passer la commande en statut "expedié" 
      const expButton = document.querySelector('#expButton');
      if (expButton) {
        // On ajoute un écouteur
        expButton.addEventListener('click',validateArticleOrder.handleCheckArticlesAreValidate);
      }
      // On récupére le bouton du form pour passer la commande en statut "validée" 
      const validateButton = document.querySelector('#validate-order');
      if (validateButton){
        // On renseigne la classe du bouton de validation
        validateArticleOrder.bindValidateButton(validateButton);
        // On ajoute un écouteur
        validateButton.addEventListener('click',validateArticleOrder.handleCheckArticlesStock);
      }
    },
    handleButtonClicked: function(event) {
      event.preventDefault();
      // On récupére le bouton cliqué
      const buttonClicked = event.currentTarget;
      // console.log(buttonClicked.id);
      // On change la valeur de validate
      validateArticleOrder.toggleValidate(buttonClicked);
      // On appel la fonction pour renseigner la classe et valeur
      validateArticleOrder.bindButton(buttonClicked);
      
    },
    bindButton: function(button) {
      // On récupére la valeur de data-validate
      let validate = button.dataset.validate;
      // On change sa classe et sa valeur en fonction de validate
      if ( validate == 0 ) {
        // On retire la classe 'btn-success'
        button.classList.remove('btn-success');
        // On ajoute la classe 'btn-secondary'
        button.classList.add('btn-secondary');
        // On renseigne son contenue
        button.textContent="Non validé";
      } else if ( validate == 1 ){
        // On retire la classe 'btn-secondary'
        button.classList.remove('btn-secondary');
        // On ajoute la classe 'btn-success'
        button.classList.add('btn-success');
        // On renseigne son contenue
        button.textContent="Validé";
      }
    },
    toggleValidate: function(button) {
      // On récupére l'input hidden correspondant au bouton
      const hiddenInput = document.getElementById(button.name);
      if(button.dataset.validate == 0) {
        button.dataset.validate = 1 ;
        // On renseigne la valeur du hiddenInput
        hiddenInput.value=button.dataset.quantityordered;
      } else if(button.dataset.validate == 1){
        button.dataset.validate = 0 ;
        // On renseigne la valeur du hiddenInput
        hiddenInput.value=0;
      }
    },
    handleCheckArticlesAreValidate: function(event){
      
      // On crée un tableau
      let noValidate = [];
      // On boucle sur la liste des articles pour vérifier si data-validate = 1
      for (const article of validateArticleOrder.buttonList) {
        if(article.dataset.validate != 1){
          noValidate.push('noValidateItem');
        }
      }
      // Si il y a quelque chose dans le tableau
      if (noValidate.length > 0) {
        event.preventDefault();
        alert("Tous les articles n'ont pas été validés !");
      } else {
        document.querySelector('#order_manager').submit();
      }

    },
    handleCheckArticlesStock: function(event){
      // On crée un variable par default
      let emptyStock = [];
      // On la remplie avec les elements de classe "emptyStock"
      emptyStock = document.querySelectorAll('.emptyStock');
      // Si il y a quelque chose dans le tableau
      if (emptyStock.length > 0) {
        event.preventDefault();
        alert("Tous les articles ne sont pas en stock !");
      } else {
        document.querySelector('#order_manager').submit();
      }
    },
    bindValidateButton: function(button){
      // On crée un variable par default
      let emptyStock = [];
      // On la remplie avec les elements de classe "emptyStock"
      emptyStock = document.querySelectorAll('.emptyStock');
      // Si il y a quelque chose dans le tableau
      if (emptyStock.length > 0) {
      button.classList.toggle('btn-success');
      button.classList.toggle('btn-danger');
      }
    }
}

document.addEventListener('DOMContentLoaded', validateArticleOrder.init);