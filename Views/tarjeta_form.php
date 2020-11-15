<?php
session_start();

/* require_once(VIEWS_PATH . "header.php");
require_once(VIEWS_PATH . "nav.php"); */
?>

<form action="/MoviePass/Compras/creditCardFunction" method="post" id="paymentForm">
   <h3>Detalles del comprador</h3>
     <div>
       <div>
         <label for="email"></label>
         <input id="email" name="email" type="text" value="<?php echo $actualUser->getEmail();?> hidden">
       </div>
       <div>
         <label for="docType">Tipo de documento</label>
         <select id="docType" name="docType" data-checkout="docType" type="text"></select>
       </div>
       <div>
         <label for="docNumber">Número de documento</label>
         <input id="docNumber" name="docNumber" data-checkout="docNumber" type="text"/>
       </div>
     </div>
   <h3>Detalles de la tarjeta</h3>
     <div>
       <div>
         <label for="cardholderName">Titular de la tarjeta</label>
         <input id="cardholderName" data-checkout="cardholderName" type="text" value="">
       </div>
       <div>
         <label for="">Fecha de vencimiento</label>
         <div>
           <input type="text" placeholder="MM" id="cardExpirationMonth" data-checkout="cardExpirationMonth"
             onselectstart="return false" onpaste="return false"
             oncopy="return false" oncut="return false"
             ondrag="return false" ondrop="return false" autocomplete=off value="">
           <span class="date-separator">/</span>
           <input type="text" placeholder="YY" id="cardExpirationYear" data-checkout="cardExpirationYear"
             onselectstart="return false" onpaste="return false"
             oncopy="return false" oncut="return false"
             ondrag="return false" ondrop="return false" autocomplete=off value="">
         </div>
       </div>
       <div>
         <label for="cardNumber">Número de la tarjeta</label>
         <input type="text" id="cardNumber" data-checkout="cardNumber"
           onselectstart="return false" onpaste="return false"
           oncopy="return false" oncut="return false"
           ondrag="return false" ondrop="return false" autocomplete=off value="">
       </div>
       <div>
         <label for="securityCode">Código de seguridad</label>
         <input id="securityCode" data-checkout="securityCode" type="text"
           onselectstart="return false" onpaste="return false"
           oncopy="return false" oncut="return false"
           ondrag="return false" ondrop="return false" autocomplete=off value="">
       </div>
       <div id="issuerInput">
         <label for="issuer">Banco emisor</label>
         <select id="issuer" name="issuer" data-checkout="issuer"></select>
       </div>
       <div>
         <input type="text" name="installments" id=""hidden value="1">
       </div>
       <div>
         <input type="hidden" name="transactionAmount" id="transactionAmount" value="<?php echo $precioTotal ?>"/>
         <input type="hidden" name="paymentMethodId" id="paymentMethodId" />
         <input type="hidden" name="description" id="description" />
         <br>
         <button type="submit">Pagar</button>
         <br>
       </div>
   </div>
 </form>
 <script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>

<script> window.Mercadopago.setPublishableKey("TEST-f0de3c39-fcbf-47a1-a0f1-0151a7c1246b"); 
window.Mercadopago.getIdentificationTypes();

document.getElementById('cardNumber').addEventListener('change', guessPaymentMethod);

function guessPaymentMethod(event) {
   let cardnumber = document.getElementById("cardNumber").value;
   if (cardnumber.length >= 6) {
       let bin = cardnumber.substring(0,6);
       window.Mercadopago.getPaymentMethod({
           "bin": bin
       }, setPaymentMethod);
   }
};

function setPaymentMethod(status, response) {
   if (status == 200) {
       let paymentMethod = response[0];
       document.getElementById('paymentMethodId').value = paymentMethod.id;

       if(paymentMethod.additional_info_needed.includes("issuer_id")){
           getIssuers(paymentMethod.id);
       } else {
           getInstallments(
               paymentMethod.id,
               document.getElementById('transactionAmount').value
           );
       }
   } else {
       alert(`payment method info error: ${response}`);
   }
}
function getIssuers(paymentMethodId) {
   window.Mercadopago.getIssuers(
       paymentMethodId,
       setIssuers
   );
}

function setIssuers(status, response) {
   if (status == 200) {
       let issuerSelect = document.getElementById('issuer');
       response.forEach( issuer => {
           let opt = document.createElement('option');
           opt.text = issuer.name;
           opt.value = issuer.id;
           issuerSelect.appendChild(opt);
       });

       getInstallments(
           document.getElementById('paymentMethodId').value,
           document.getElementById('transactionAmount').value,
           issuerSelect.value
       );
   } else {
       alert(`issuers method info error: ${response}`);
   }
}
doSubmit = false;
document.getElementById('paymentForm').addEventListener('submit', getCardToken);
function getCardToken(event){
   event.preventDefault();
   if(!doSubmit){
       let $form = document.getElementById('paymentForm');
       window.Mercadopago.createToken($form, setCardTokenAndPay);
       return false;
   }
};

function setCardTokenAndPay(status, response) {
   if (status == 200 || status == 201) {
       let form = document.getElementById('paymentForm');
       let card = document.createElement('input');
       card.setAttribute('name', 'token');
       card.setAttribute('type', 'hidden');
       card.setAttribute('value', response.id);
       form.appendChild(card);
       doSubmit=true;
       form.submit();
   } else {
       alert("Verify filled data!\n"+JSON.stringify(response, null, 4));
   }
};

</script>
