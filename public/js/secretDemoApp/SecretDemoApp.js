/**
 * @description It has a self contained logic to hide it from global scope
 */
(function(global){

   function SecretDemoApp(){
       //get reference to needed UI objects
       //subscribe to click/submit events
            //manage data flow
            //manage UI change

       //fill up the hash select-list
       //handle "form post" event on both peek button

       //manage add new "submit" button

   }


   SecretDemoApp.models = {
       //TODO: add a descriptive JS Doc for Secret model
       /**
        *
        * @constructor
        */
       Secret: function(){
           this.hash = null;
           this.secretText = null;
           this.createdAt = null;
           this.expiresAt = null;
           this.remainingViews = null;

           //TODO: Add validation logic for Secret object
       },
       /**
        * @description A ViewModel to support Secret object creation on http POST
        * @property {string} secret This text will be saved as a secret
        * @property {int} expiresAfter The secret won’t be available after the given time. The value is provided in minutes. 0 means never expires
        * @property {int} expiresAfterViews The secret won’t be available after the given number of views. It must be greater than 0.
        * @constructor
        */
       SecretPostVM: function(){
           this.secret = "";
           this.expiresAfter = 0;
           this.expiresAfterViews = 1;

           //TODO: Validation logic could come here for SecretPostVM
       }
   };

   SecretDemoApp.services = {
       http: {
           getSecret : function(hash){
               return $.ajax({
                   url: "/secret/" + hash,
                   method: "GET"
               });
           },
           getSecretHashes : function(){
               return $.ajax({
                   url: "/secret_hashes",
                   method: "GET"
               });
           },
           postSecret:function(secretPostVM){
               return $.ajax({
                   url: "/secret",
                   method: "POST",
                   data: secretPostVM
               });
           }
       }
   };


    console.log("Hello There from secret demo app");
   //initialise the app
   new SecretDemoApp();

})(window);