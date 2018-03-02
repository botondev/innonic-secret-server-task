/**
 * @description It has a self contained logic to hide it from global scope
 */
(function(global){

   function SecretDemoApp(){

       //hook up the select list
       SecretDemoApp.ui.prepareSecretList();
       SecretDemoApp.ui.handlePeekFromText();
       SecretDemoApp.ui.handleSubmitSecret();

   }

    SecretDemoApp.ui = {
        fillSelectList: function(secrets){
            var $select = $("#secretList");
            $select.empty().append($("<option>",{
                value: "",
                text: "Select a secret hash"
            }));
            for(var i in secrets){
                console.log(secrets[i]);
                $select.append($("<option>",{
                    value: secrets[i].hash,
                    text: secrets[i].hash + " ("+secrets[i].remainingViews+")"
                }))
            }
        },
        prepareSecretList: function(){
            SecretDemoApp.services.http.getSecretHashes()
                .done(function(secrets){
                    console.log("success->selectList: ", secrets);

                    SecretDemoApp.ui.fillSelectList(secrets);
                    SecretDemoApp.ui.handlePeekFromList();
                })
                .fail(function(jqXHR, textStatus, errorThrown){
                    //TODO: show error message in first select option on fail
                    //msg: "Out of service". Disable the select field and button.
                });
        },
        handleSubmitSecret: function(){
            $("#submitSecret").click(function(){
                //build secret
                var secretPostVM = new SecretDemoApp.models.SecretPostVM();
                secretPostVM.secret = $("#secretText").val();
                secretPostVM.expireAfter = $("#expireAfterMinutes").val();
                secretPostVM.expireAfterViews = $("#expireAfterViews").val();

                //post secret
                SecretDemoApp.services.http.postSecret(secretPostVM)
                    .done(function(newSecret){
                        SecretDemoApp.ui.clearSecretPostForm();
                        SecretDemoApp.ui.displaySecret(newSecret);
                        $("#secretPostFormError").hide();
                        SecretDemoApp.ui.prepareSecretList(); //reset/update list
                    })
                    .fail(function(){
                        $("#secretPostFormError").show();

                        //NOTE: bad practice: copy pasted code
                        // breaking DO NOT REPEAT YOURSELF principle
                        // should be in its separate function
                        $("#selectedSecretDetailsBox").hide();
                    });
            });
        },
        clearSecretPostForm: function(){
            var secretPostVM = new SecretDemoApp.models.SecretPostVM();
            $("#secretText").val(secretPostVM.secret);
            $("#expireAfterMinutes").val(secretPostVM.expireAfter);
            $("#expireAfterViews").val(secretPostVM.expireAfterViews);

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
                    alert("No secret hash was typed");
                }

            });
        },
       displaySecretByHash: function(hash){
           //get secret
           SecretDemoApp.services.http.getSecret(hash)
               .done(function(data){
                   console.log("We got the full  secret:", data);
                   SecretDemoApp.ui.displaySecret(data);
               })
               .fail(function(jqXHR, textStatus, errorThrown){
                   alert(textStatus + ": " + errorThrown);
                   $("#selectedSecretDetailsBox").hide();
               });
       },
        displaySecret: function(secret){

            //Note: bad practice: multiple responsibility
            // this functions breaking the SINGLE RESPONSIBILITY PRINCIPLE
            // because firstly it handles filling the form
            // secondly it is responsible for "show"ing the content

            $("#staticHash").val(secret.hash.toLocaleString());
            $("#staticSecretText").val(secret.secretText);
            $("#staticCreatedAt").val(secret.createdAt.date);
            $("#staticExpiresAt").val(secret.expiresAt != null ? secret.expiresAt.date : null);
            $("#staticRemainingViews").val(secret.remainingViews);

            $("#selectedSecretDetailsBox").show();
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
        * @property {int} expireAfter The secret won’t be available after the given time. The value is provided in minutes. 0 means never expires
        * @property {int} expireAfterViews The secret won’t be available after the given number of views. It must be greater than 0.
        * @constructor
        */
       SecretPostVM: function(){
           this.secret = "";
           this.expireAfter = 0;
           this.expireAfterViews = 1;

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