let selectvalue = "" , nombre = 1;
let info = [];

let formulaire;
let description;

function changeformulaire() {
    formulaire = document.getElementById("title_formulaire").value;
    description = document.getElementById("formulaire_description").value;
}

function AddQestion(){
    let title = document.getElementById("title_question").value;
    let submit = document.getElementById("submit");
    let nombrediv = document.getElementsByName("component").length +1;

     // creation Element

    let div1 = document.createElement('div');
    let div2 = document.createElement('div');
    let h5 = document.createElement('h5');
    let element;

    if(formulaire != null && formulaire != ""){
        if(title != null && title != ""){
            if(selectvalue != ""){
                document.getElementById("title_formulaire").readOnly = true;
                document.getElementById("formulaire_description").readOnly = true;
                if(selectvalue == "radio") {
                    nombre = document.getElementById("modal_numbers_radio").value;
                    if(nombre >= 2){
                        elements = NewElement(selectvalue , nombre);
                        if(elements != null) {
                            h5.setAttribute("name",`qestion_${nombrediv}`)
                            h5.textContent = title;
                            div1.setAttribute('class',"card border border-primary");
                            div1.setAttribute('id',`component${nombrediv}`);
                            div1.setAttribute('name',"component");

                            div2.setAttribute('class',"card-body");
                            div2.appendChild(h5);

                            for(let i = 0 ; i<elements.length ; i++){
                                div2.appendChild(elements[i]);
                            }

                            div1.appendChild(div2);
                            submit.parentNode.insertBefore(div1 , submit)

                            $.ajax({
                                method:'GET',
                                url:"/admin/form/store/add-field",
                                data:info,
                                dataType:"json",
                                success: function (response) {
                                    tostersucess();
                                    console.log(response.message);
                                },
                                error: function (response) {
                                    tostererror();
                                    console.log("Error");
                                }
                            });

                        }else{

                        }
                    }else{
                        messagee("Choix multiple: Les options doivent être égales ou supérieures à deux");
                    }
                } else if(selectvalue == "checkbox") {
                    nombre = document.getElementById("modal_numbers_checkbox").value;
                    if(nombre >= 2){
                        elements = NewElement(selectvalue , nombre);
                        if(elements != null) {
                            h5.setAttribute("name",`qestion_${nombrediv}`)
                            h5.textContent = title;
                            div1.setAttribute('class',"card border border-primary");
                            div1.setAttribute('id',`component${nombrediv}`);
                            div1.setAttribute('name',"component");

                            div2.setAttribute('class',"card-body");
                            div2.appendChild(h5);

                            for(let i = 0 ; i<elements.length ; i++){
                                div2.appendChild(elements[i]);
                            }

                            div1.appendChild(div2);
                            submit.parentNode.insertBefore(div1 , submit);

                            $.ajax({
                                method:'GET',
                                url:"/admin/form/store/add-field",
                                data:info,
                                dataType:"json",
                                success: function (response) {
                                    console.log(response.message);
                                    tostersucess();
                                },
                                error: function (response) {
                                    console.log("Error");
                                    tostererror();
                                }
                            });

                        }else{

                        }
                    }else{
                        messagee("Cases à cocher : Les options doivent être égales ou supérieures à deux");
                    }

                }else if(selectvalue == "select") {
                    nombre = document.getElementById("modal_numbers_select").value;
                    if(nombre>=2){
                        element = NewElement(selectvalue , nombre);
                        if(element != null) {
                            h5.setAttribute("name",`qestion_${nombrediv}`)
                            h5.textContent = title;
                            div1.setAttribute('class',"card border border-primary");
                            div1.setAttribute('id',`component${nombrediv}`);
                            div1.setAttribute('name',"component");

                            div2.setAttribute('class',"card-body");
                            div2.appendChild(h5);

                            div2.appendChild(element);

                            div1.appendChild(div2);
                            submit.parentNode.insertBefore(div1 , submit);

                            $.ajax({
                                method:'GET',
                                url:"/admin/form/store/add-field",
                                data:info,
                                dataType:"json",
                                success: function (response) {
                                    console.log(response.message);
                                    tostersucess();
                                },
                                error: function (response) {
                                    console.log("Error");
                                    tostererror();
                                }
                            });
                        }
                    }else{
                        messagee("List déroulante : Les options doivent être égales ou supérieures à deux");
                    }


                }else {
                    element = NewElement(selectvalue , 1);
                    if(element != null) {

                        div1.setAttribute('class',"card border border-primary");
                        div1.setAttribute('id',`component${nombrediv}`);
                        div1.setAttribute('name',"component");

                        h5.setAttribute("name",`qestion_${nombrediv}`)
                        h5.textContent = title;



                        div2.setAttribute('class',"card-body");
                        div2.appendChild(h5);
                        div2.appendChild(element);

                        div1.appendChild(div2);

                        submit.parentNode.insertBefore(div1 , submit);

                        $.ajax({
                            method:'GET',
                            url:"/admin/form/store/add-field",
                            data:info,
                            dataType:"json",
                            success: function (response) {
                                tostersucess();
                                console.log(response.message);
                            },
                            error: function (response) {
                                console.log("Error");
                                tostererror();
                            }
                        });
                    }
                }
            }else{
                messagee("Vous devez spécifier un contrôle");
            }
        }else{
            messagee("La question doit être saisie");
        }
    }else {
        messagee("Le titre du formulaire doit être saisi avant ajouter une question");
    }

}

function NewElement(type , nombre) {
    if(type != ""){
        if(type == "text") {
            let text = document.createElement("input");
            let nombrediv = document.getElementsByName("component").length + 1;
            let title = document.getElementById("title_question").value;

            text.setAttribute("name", `reponse_Q_${nombrediv}`);
            text.setAttribute("type", "text");
            text.setAttribute("class", "form-control mt-1");
            text.setAttribute("placeholder", "Votre reponse");

            info = {
                "formulaire":formulaire,
                "description":description,
                "controlname":"input",
                "controltype":"text",
                "question":title,
                "attrname":`reponse_Q_${nombrediv}`,
                "attrplaceholder":"Votre reponse",
            };

            return text;
        } else if(type == "email") {
            let email = document.createElement("input");
            let nombrediv = document.getElementsByName("component").length + 1;
            let title = document.getElementById("title_question").value;

            email.setAttribute("name", `reponse_Q_${nombrediv}`);
            email.setAttribute("type", "email");
            email.setAttribute("class", "form-control mt-1");
            email.setAttribute("placeholder", "Votre E-Mail");

            info = {
                "formulaire":formulaire,
                "description":description,
                "controlname":"input",
                "controltype":"email",
                "question":title,
                "attrname":`reponse_Q_${nombrediv}`,
                "attrplaceholder":"Email",
            };

            return email;
        } else if(type == "radio") {
            let abc = document.getElementById("modal_radio_option_1").value;
            if(abc != "" && abc != null) {
                let arrayRadio = [];
                let nombrediv = document.getElementsByName("component").length + 1;
                let title = document.getElementById("title_question").value;

                info = {
                    "formulaire":formulaire,
                    "description":description,
                    "controlname":"input",
                    "controltype":"radio",
                    "question":title,
                    "nombreoption":nombre,
                    "attrname":`reponse_Q_${nombrediv}`,
                    "attrplaceholder":"radio",
                };

                for(let i =0 ;i<nombre ;i++) {
                    let text  = document.getElementById("modal_radio_option_"+(i+1)).value;
                    if(text != "" && text != null) {
                        let div   = document.createElement("div");
                        let radio = document.createElement("input");
                        let label = document.createElement("label");

                        div.setAttribute("class","form-check")

                        radio.setAttribute("name", "radio_option_Q_"+nombrediv);
                        radio.setAttribute("type", "radio");
                        radio.setAttribute("class", "form-check-input mt-1");
                        radio.setAttribute("value", text);

                        label.appendChild(radio);
                        label.appendChild(document.createTextNode(text));

                        div.appendChild(label);

                        let option = `option${i+1}`;
                        info[option]=text;

                        arrayRadio = [...arrayRadio , div];
                    }else{
                        abc = "";
                    }
                }
                if(abc != ""){
                    return arrayRadio;
                }else{
                    messagee("Les options que vous avez créées doivent être renseignées");
                }
            } else {
                messagee("Les options que vous avez créées doivent être renseignées");
            }
        } else if(type == "checkbox") {
            let arrayCheckbox = [];
            let nombrediv = document.getElementsByName("component").length + 1;
            let title = document.getElementById("title_question").value;

            let abc = document.getElementById("modal_checkbox_option_1").value;

            if(abc != "" && abc != null) {
                info = {
                    "formulaire":formulaire,
                    "description":description,
                    "controlname":"input",
                    "controltype":"checkbox",
                    "question":title,
                    "nombreoption":nombre,
                    "attrname":`reponse_Q_${nombrediv}`,
                    "attrplaceholder":"checkbox",
                };

                for(let i =0 ;i<nombre ;i++) {
                    let text = document.getElementById("modal_checkbox_option_"+(i+1)).value;
                    if(text != "" && text != null){
                        let div  = document.createElement("div");
                        let checkbox = document.createElement("input");
                        let label = document.createElement("label");

                        div.setAttribute("class","form-check");

                        checkbox.setAttribute("name", `checkbox_option_Q_${nombrediv}_C_${i+1}`);
                        checkbox.setAttribute("type", "checkbox");
                        checkbox.setAttribute("class", "form-check-input mt-1");
                        checkbox.setAttribute("value", text);

                        let option = `option${i+1}`;
                        info[option]=text;


                        label.appendChild(checkbox);
                        label.appendChild(document.createTextNode(text));

                        div.appendChild(label);

                        arrayCheckbox = [...arrayCheckbox , div];

                    }else{
                        abc ="";
                    }
                }

                    if(abc != ""){
                        return arrayCheckbox;
                    }else{
                        messagee("Les options que vous avez créées doivent être renseignées");
                    }
            }else{
                messagee("Les options que vous avez créées doivent être renseignées");
            }
        } else if(type == "select") {
            let abc = document.getElementById("modal_select_option_1").value;

            if(abc != "" && abc != null){
                let nombrediv = document.getElementsByName("component").length + 1;
                let select = document.createElement("select");
                let div  = document.createElement("div");
                let title = document.getElementById("title_question").value;

                div.setAttribute("class","form-group")

                select.setAttribute("name", `select_option_Q_${nombrediv}`);
                select.setAttribute("class", "form-control mt-1");

                info = {
                    "formulaire":formulaire,
                    "description":description,
                    "controlname":"select",
                    "controltype":"select",
                    "question":title,
                    "nombreoption":nombre,
                    "attrname":`reponse_S_${nombrediv}`,
                    "attrplaceholder":"select",
                };

                for(let i = 0 ;i<nombre ;i++) {
                    let text = document.getElementById("modal_select_option_"+(i+1)).value;
                    if(text != "" && text != null){
                        let option = document.createElement("option");

                        let seletoption = `option${i+1}`;
                        info[seletoption]=text;

                        option.setAttribute("value", text);
                        option.textContent = text;
                        select.appendChild(option);

                    }else{
                        abc ="";
                    }
                }

                if(abc != ""){
                    div.appendChild(select);
                    return div;
                }else{
                    messagee("Les options que vous avez créées doivent être renseignées");
                }


            }else{
                messagee("Les options que vous avez créées doivent être renseignées");
            }

        } else if(type == "fichier") {
            let file = document.createElement("input");
            let nombrediv = document.getElementsByName("component").length + 1;
            let title = document.getElementById("title_question").value;

            file.setAttribute("name", `reponse_Q_${nombrediv}`);
            file.setAttribute("type", "file");
            file.setAttribute("class", "form-control mt-1");

            info = {
                "formulaire":formulaire,
                "description":description,
                "controlname":"input",
                "controltype":"file",
                "question":title,
                "attrname":`reponse_Q_${nombrediv}`,
                "attrplaceholder":"fichier",
            };

            return file;
        } else if(type == "date") {
            let date = document.createElement("input");
            let nombrediv = document.getElementsByName("component").length + 1;
            let title = document.getElementById("title_question").value;

            date.setAttribute("name", `reponse_Q_${nombrediv}`);
            date.setAttribute("type", "date");
            date.setAttribute("class", "form-control mt-1");

            info = {
                "formulaire":formulaire,
                "description":description,
                "controlname":"input",
                "controltype":"date",
                "question":title,
                "attrname":`reponse_Q_${nombrediv}`,
                "attrplaceholder":"date",
            };

            return date;
        } else if(type == "heure") {
            let heure = document.createElement("input");
            let nombrediv = document.getElementsByName("component").length + 1;
            let title = document.getElementById("title_question").value;

            heure.setAttribute("name", `reponse_Q_${nombrediv}`);
            heure.setAttribute("type", "time");
            heure.setAttribute("class", "form-control mt-1");

            info = {
                "formulaire":formulaire,
                "description":description,
                "controlname":"input",
                "controltype":"time",
                "question":title,
                "attrname":`reponse_Q_${nombrediv}`,
                "attrplaceholder":"heure",
            };

            return heure;
        } else if(type == "textarea") {
            let text = document.createElement("input");
            let nombrediv = document.getElementsByName("component").length + 1;
            let title = document.getElementById("title_question").value;

            let textarea = document.createElement('textarea');
            textarea.setAttribute("name", "reponse");
            textarea.setAttribute("cols", "30");
            textarea.setAttribute("rows", "2");
            textarea.setAttribute("class", "form-control mt-1");
            textarea.setAttribute("placeholder", "votre réponse");


            info = {
                "formulaire":formulaire,
                "description":description,
                "controlname":"textarea",
                "controltype":"textarea",
                "question":title,
                "attrname":`reponse_Q_${nombrediv}`,
                "attrplaceholder":"Votre reponse",
            };

            return textarea;
        }
    }else{
        return null;
    }

}

function changeselect(valeur) {
    let button = document.getElementById("dropdownMenuButtonIcon");

    let radio = document.getElementById('modal_numbers_radio');
    let checkbox = document.getElementById('modal_numbers_checkbox');
    let select = document.getElementById('modal_numbers_select');

    let label_checkbox = document.getElementById('modal_checkbox_label');
    let label_radio = document.getElementById('modal_radio_label');
    let label_select = document.getElementById('modal_select_label');

    nombre = 1;

    label_checkbox.value = 0;
    label_radio.value = 0;
    label_select.value = 0;

    if(valeur == "text")
        button.textContent = `Réponse court`;
    else if(valeur == "textarea")
         button.textContent = "Paragraphe";
    else if(valeur == "radio")
         button.textContent = "Choix multiples";
    else if(valeur == "checkbox")
         button.textContent = "Cases à cocher";
    else if(valeur == "select")
         button.textContent = "List déroulante";
    else if(valeur == "fichier")
         button.textContent = "Importer un ficher";
    else if(valeur == "date")
         button.textContent = "Date";
    else if(valeur == "email")
         button.textContent = "E-mail";
    else if(valeur == "heure")
         button.textContent = "Heure";

    selectvalue = valeur;

    if(valeur == "radio") {
        label_checkbox.innerHTML = "";
        label_radio.innerHTML = "";
        label_select.innerHTML = "";

        radio.hidden = false;
        checkbox.hidden = true;
        select.hidden = true;

    }else if(valeur == "checkbox") {
        label_checkbox.innerHTML = "";
        label_radio.innerHTML = "";
        label_select.innerHTML = "";

        checkbox.hidden = false;
        radio.hidden = true;
        select.hidden = true;
    }else if(valeur == "select") {
        label_checkbox.innerHTML = "";
        label_radio.innerHTML = "";
        label_select.innerHTML = "";

        checkbox.hidden = true;
        radio.hidden = true;
        select.hidden = false;
    }else {
        radio.hidden = true;
        checkbox.hidden = true;
        select.hidden = true;

        label_radio.innerHTML = "";
        label_checkbox.innerHTML = "";
        label_select.innerHTML = "";
    }
}

function createradiolabel() {

    let div1 = document.getElementById('modal_radio_label');

    div1.innerHTML = "";

    lables = [];
    nombre = document.getElementById('modal_numbers_radio').value;
    for(let i = 0 ;i<nombre ;i++) {
        let name = "modal_radio_option_"+(i+1);

        div1.innerHTML += `
            <div class="form-check" name="modaloption">
                <input type="text" id=${name} placeholder="Ecrire ici" class="form-control" />
            </idv>
        `;
    }

}

function createcheckboxlabel() {
    let div1 = document.getElementById('modal_checkbox_label');

    div1.innerHTML = "";

    nombre = document.getElementById('modal_numbers_checkbox').value;
    for(let i = 0 ;i<nombre ;i++) {
        let name = "modal_checkbox_option_"+(i+1);

        div1.innerHTML += `
            <div class="form-check" name="modaloption">
                <input type="text" id=${name} placeholder="Ecrire ici" class="form-control" />
            </idv>
        `;
    }
}

function createselectlabel() {
    let div1 = document.getElementById('modal_select_label');

    div1.innerHTML = "";

    nombre = document.getElementById('modal_numbers_select').value;
    for(let i = 0 ;i<nombre ;i++) {
        let name = "modal_select_option_"+(i+1);

        div1.innerHTML += `
            <div class="form-check" name="modaloption">
                <input type="text" id=${name} placeholder="Ecrire ici" class="form-control" />
            </idv>
        `;
    }
}

function tostersucess() {
    Toastify({
        text: "Question ajoutée avec succès",
        duration: 3000,
        close:true,
        backgroundColor: "#4fbe87",
    }).showToast();
}

function tostererror(){
    Toastify({
        text: "Il y a une erreur, actualisez la page",
        duration: 3000,
        close:true,
        backgroundColor: "#FF0000",
    }).showToast();
}

function messagee(description){
    Toastify({
        text: description,
        duration: 3000,
        close:true,
        backgroundColor: "#FF0000",
    }).showToast();
}
