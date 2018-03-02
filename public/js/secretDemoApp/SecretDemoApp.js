/**
 * @description It has a self contained logic to hide it from global scope
 */
(function(global){

   function SecretDemoApp(){
       //hook up the select list
       this.secretListInitialised = false;
        SecretDemoApp.services.http.getSecretHashes()
            .done(function(secrets){
                console.log("success->selectList: ", secrets);
                this.secretListInitialised = true;

                SecretDemoApp.ui.fillSelectList(secrets);
                SecretDemoApp.ui.handlePeekFromList();
                SecretDemoApp.ui.handlePeekFromText();
            })
            .fail(function(jqXHR, textStatus, errorThrown){
                //show error message in first select option
                //msg: "Out of service". Disable the select field and button.
            });

       //get reference to needed UI objects
       //subscribe to click/submit events
       $("#peekFromList").click(function(){

       });
       $("#peekFromText").click(function(){

       });

       $("#submitSecret").click(function(){

       });
            //manage data flow
            //manage UI change

       //fill up the hash select-list
       //handle "form post" event on both peek button

       //manage add new "submit" button

   }

    SecretDemoApp.ui = {
        fillSelectList: function(secrets){
            var $select = $("#secretList");

            for(var i in secrets){
                console.log(secrets[i]);
                $select.append($("<option>",{
                    value: secrets[i].hash,
                    text: secrets[i].hash + " ("+secrets[i].remainingViews+")"
                }))
            }
        },
        handlePeekFromList: function(){
            $("#peekFromList").click(function(){
                var $select = $("#secretList");

                var hash = $select.val();
                if(hash){
                    SecretDemoApp.ui.displaySecretByHash(hash);
                }else{
                    alert("No secret was selected");
                }

            });
        },
        handlePeekFromText: function(){
            $("#peekFromText").click(function(){
                var $text = $("#secretTextPeek");

                var hash = $text.val();
                if(hash){
                    SecretDemoApp.ui.displaySecretByHash(hash);
                }else{
                    alert("No secret hsh was typed");
                }

            });
        },
       displaySecretByHash: function(hash){
           //get secret
           SecretDemoApp.services.http.getSecret(hash)
               .done(function(data){
                   console.log("We got the full  secret:", data);
                   SecretDemoApp.ui.displaySecret(data);
                   $("#selectedSecretDetailsBox").show();
               })
               .fail(function(jqXHR, textStatus, errorThrown){
                   alert(textStatus + ": " + errorThrown);
                   $("#selectedSecretDetailsBox").hide();
               });
       },
        displaySecret: function(secret){

            $("#staticHash").val(secret.hash);
            $("#staticSecretText").val(secret.secretText);
            $("#staticCreatedAt").val(secret.createdAt.date);
            $("#staticExpiresAt").val(secret.expiresAt.date);
            $("#staticRemainingViews").val(secret.remainingViews);
        }
    };

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

           //TODO: We could use a Factory to "mimic" multiple constructor behaviour

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
       /**
        * All http service returns a promise we can reuse when the http call is done.
        */
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