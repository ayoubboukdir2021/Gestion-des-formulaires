
let info = [];
let questioninfo = [];
let nombre = 1;
let selectvalue = "";

function editquestion() {
    let modaltextarea = document.getElementById('title_question_'+questioninfo[0].id).value;
    let obligatoire1 = document.getElementById('obligatoire_q1_'+questioninfo[0].id).value;
    let obligatoire2 = document.getElementById('obligatoire_q2_'+questioninfo[0].id).value;

    info["titrequestion"]=modaltextarea;
    if(obligatoire2.checked)
        info["obligatory"]=0;
    else
        info["obligatory"]=1;

    if(selectvalue == "text"){
        info["control"]="input";
        info["type"]="text";
        info["attrname"]=`reponse_Q_${info.id}`;

        $.ajax({
            method:'GET',
            url:"/admin/form/edit/question",
            data:info,
            dataType:"json",
            success: function (response) {

                newquestion(response.message);
            },
            error: function (response) {
                console.log("Error");
                tostererror();
            }
        });

    }else if(selectvalue == "email"){
        info["control"]="input";
        info["type"]="email";

        info["attrname"]=`reponse_Q_${info.id}`;
        $.ajax({
            method:'GET',
            url:"/admin/form/edit/question",
            data:info,
            dataType:"json",
            success: function (response) {
                console.log(response.message);
                newquestion(response.message);
            },
            error: function (response) {
                console.log("Error");
            }
        });
    }else if(selectvalue == "date"){
        info["control"]="input";
        info["type"]="date";

        info["attrname"]=`reponse_Q_${info.id}`;

        $.ajax({
            method:'GET',
            url:"/admin/form/edit/question",
            data:info,
            dataType:"json",
            success: function (response) {
                console.log(response.message);
                newquestion(response.message);
            },
            error: function (response) {
                console.log("Error");
            }
        });


    }else if(selectvalue == "fichier"){
        info["control"]="input";
        info["type"]="file";

        info["attrname"]=`reponse_Q_${info.id}`;

        $.ajax({
            method:'GET',
            url:"/admin/form/edit/question",
            data:info,
            dataType:"json",
            success: function (response) {
                console.log(response.message);
                newquestion(response.message);
            },
            error: function (response) {
                console.log("Error");
            }
        });

    }else if(selectvalue == "heure"){
        info["control"]="input";
        info["type"]="time";

        info["attrname"]=`reponse_Q_${info.id}`;

        $.ajax({
            method:'GET',
            url:"/admin/form/edit/question",
            data:info,
            dataType:"json",
            success: function (response) {
                console.log(response.message);
                newquestion(response.message);
            },
            error: function (response) {
                console.log("Error");
            }
        });
    }else if(selectvalue == "radio"){
        info["control"]="input";
        info["type"]="radio";

        info["nombreoptions"] = nombre;

        info["attrname"]=`reponse_Q_${info.id}`;

        for (let i = 0; i < nombre; i++) {
            let nameoption = "option"+(i+1);
            let valeuroption = document.getElementById(nameoption);
            info[nameoption] = valeuroption.value;
        }

        $.ajax({
            method:'GET',
            url:"/admin/form/edit/question",
            data:info,
            dataType:"json",
            success: function (response) {
                console.log(response.message);
                newquestion(response.message);
            },
            error: function (response) {
                console.log("Error");
            }
        });

    }else if(selectvalue == "checkbox"){
        info["control"]="input";
        info["type"]="checkbox";

        info["nombreoptions"] = nombre;

        info["attrname"]=`reponse_Q_${info.id}`;

        for (let i = 0; i < nombre; i++) {
            let nameoption = "modal_checkbox_Q_"+questioninfo[0].id+"option_"+(i+1);
            let valeuroption = document.getElementById(nameoption);
            info[nameoption] = valeuroption.value;
        }

        $.ajax({
            method:'GET',
            url:"/admin/form/edit/question",
            data:info,
            dataType:"json",
            success: function (response) {
                console.log(response.message);
                newquestion(response.message);
            },
            error: function (response) {
                console.log("Error");
            }
        });

    }else if(selectvalue == "textarea"){
        info["control"]="textarea";
        info["type"]="textarea";

        info["attrname"]=`reponse_Q_${info.id}`;

        $.ajax({
            method:'GET',
            url:"/admin/form/edit/question",
            data:info,
            dataType:"json",
            success: function (response) {
                console.log(response.message);
                newquestion(response.message);
            },
            error: function (response) {
                console.log("Error");
            }
        });
    }else if(selectvalue == "select"){
        info["control"]="select";
        info["type"]="select";



        info["nombreoptions"] = nombre;

        info["attrname"]=`reponse_Q_${info.id}`;

        for (let i = 0; i < nombre; i++) {
            let nameoption = "modal_select_Q_"+questioninfo[0].id+"option_"+(i+1);
            let valeuroption = document.getElementById(nameoption);
            info[nameoption] = valeuroption.value;
        }
        console.log(info);

        $.ajax({
            method:'GET',
            url:"/admin/form/edit/question",
            data:info,
            dataType:"json",
            success: function (response) {
                console.log(response.message);
                newquestion(response.message);
            },
            error: function (response) {
                console.log("Error");
            }
        });
    }

}

function question(id) {
    info = {
        "id":id,
    }

    $.ajax({
        method:'GET',
        url:"/admin/form/question",
        data:info,
        dataType:"json",
        success: function (response) {
            questioninfo = response.message;
            movedata();
        },
        error: function (response) {
            tostererror();
            console.log("Error");
        }
    });

}

function movedata() {
    if(questioninfo[0].controls[0].name == "input") {
        if(questioninfo[0].controls[0].type == "text") {
            let modaltextarea = document.getElementById('title_question_'+questioninfo[0].id);
            let selectchange = document.getElementById("dropdownMenuButtonIcon_"+questioninfo[0].id);
            selectchange.textContent = `Réponse court`;
            modaltextarea.value = questioninfo[0].title;
            selectvalue = "text";
        }else if(questioninfo[0].controls[0].type == "email"){
            let modaltextarea = document.getElementById('title_question_'+questioninfo[0].id);
            let selectchange = document.getElementById("dropdownMenuButtonIcon_"+questioninfo[0].id);
            selectchange.textContent = `E-mail`;
            modaltextarea.value = questioninfo[0].title;
            selectvalue = "email";
        }else if(questioninfo[0].controls[0].type == "date"){
            let modaltextarea = document.getElementById('title_question_'+questioninfo[0].id);
            let selectchange = document.getElementById("dropdownMenuButtonIcon_"+questioninfo[0].id);
            selectchange.textContent = `Date`;
            modaltextarea.value = questioninfo[0].title;
            selectvalue = "date";
        }else if(questioninfo[0].controls[0].type == "time"){
            let modaltextarea = document.getElementById('title_question_'+questioninfo[0].id);
            let selectchange = document.getElementById("dropdownMenuButtonIcon_"+questioninfo[0].id);
            selectchange.textContent = `Heure`;
            modaltextarea.value = questioninfo[0].title;
            selectvalue = "heure";
        }else if(questioninfo[0].controls[0].type == "file"){
            let modaltextarea = document.getElementById('title_question_'+questioninfo[0].id);
            let selectchange = document.getElementById("dropdownMenuButtonIcon_"+questioninfo[0].id);
            selectchange.textContent = `Importer un ficher`;
            modaltextarea.value = questioninfo[0].title;
            selectvalue = "fichier";
        }else if(questioninfo[0].controls[0].type == "checkbox"){
            let modaltextarea = document.getElementById('title_question_'+questioninfo[0].id);
            let selectchange = document.getElementById("dropdownMenuButtonIcon_"+questioninfo[0].id);
            selectchange.textContent = `Cases à cocher`;
            modaltextarea.value = questioninfo[0].title;


            let div1 = document.getElementById('modal_checkbox_label_'+questioninfo[0].id);
            div1.innerHTML = "";

            nombre = questioninfo[1].length;
            selectvalue = "checkbox";

            nombre = questioninfo[1].length;

            for(let i = 0; i < nombre; i++){
                let name = "modal_checkbox_Q_"+questioninfo[0].id+"option_"+(i+1);
                div1.innerHTML += `
                    <div class="form-check" name="modaloption">
                        <input type="text" id="${name}" placeholder="Ecrire ici" class="form-control" value="${questioninfo[1][i].value}"/>
                    </idv>
                `;
            }

        }else if(questioninfo[0].controls[0].type == "radio"){
            let modaltextarea = document.getElementById('title_question_'+questioninfo[0].id);
            let selectchange = document.getElementById("dropdownMenuButtonIcon_"+questioninfo[0].id);
            selectchange.textContent = `Choix multiples`;
            modaltextarea.value = questioninfo[0].title;


            let div1 = document.getElementById('modal_radio_label_'+questioninfo[0].id);
            div1.innerHTML = "";

            nombre = questioninfo[1].length;
            selectvalue = "radio";

            for(let i = 0; i < nombre; i++){
                let name = "option"+(i+1);
                div1.innerHTML += `
                    <div class="form-check" name="modaloption">
                        <input type="text" id="${name}" placeholder="Ecrire ici" class="form-control" value="${questioninfo[1][i].value}"/>
                    </idv>
                `;
            }


        }
    }else if(questioninfo[0].controls[0].name == "select"){
        let modaltextarea = document.getElementById('title_question_'+questioninfo[0].id);
        let selectchange = document.getElementById("dropdownMenuButtonIcon_"+questioninfo[0].id);
        selectchange.textContent = `List déroulante`;
        modaltextarea.value = questioninfo[0].title;


        let div1 = document.getElementById('modal_select_label_'+questioninfo[0].id);
        div1.innerHTML = "";

        nombre = questioninfo[1].length;
        selectvalue = "select";

        for(let i = 0; i < nombre; i++){
            let name = "modal_select_Q_"+questioninfo[0].id+"option_"+(i+1);
            div1.innerHTML += `
                <div class="form-check" name="modaloption">
                    <input type="text" id="${name}" placeholder="Ecrire ici" class="form-control" value="${questioninfo[1][i].value}"/>
                </idv>
            `;
        }


    }else if(questioninfo[0].controls[0].name == "textarea"){
        let modaltextarea = document.getElementById('title_question_'+questioninfo[0].id);
        let selectchange = document.getElementById("dropdownMenuButtonIcon_"+questioninfo[0].id);
        selectchange.textContent = `Paragraphe`;
        modaltextarea.value = questioninfo[0].title;

        selectvalue = "textarea";
    }
}

function changeselect(valeur) {

    let button = document.getElementById("dropdownMenuButtonIcon_"+questioninfo[0].id);

    let radio = document.getElementById('modal_numbers_radio_'+questioninfo[0].id);
    let checkbox = document.getElementById('modal_numbers_checkbox_'+questioninfo[0].id);
    let select = document.getElementById('modal_numbers_select_'+questioninfo[0].id);

    let label_checkbox = document.getElementById('modal_checkbox_label_'+questioninfo[0].id);
    let label_radio = document.getElementById('modal_radio_label_'+questioninfo[0].id);
    let label_select = document.getElementById('modal_select_label_'+questioninfo[0].id);

    label_checkbox.value = 0;
    label_radio.value = 0;
    label_select.value = 0;

    nombre = 1;

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
    let div1 = document.getElementById('modal_radio_label_'+questioninfo[0].id);

    div1.innerHTML = "";

    nombre = document.getElementById('modal_numbers_radio_'+questioninfo[0].id).value;
    for(let i = 0 ;i<nombre ;i++) {
        let name = "option"+(i+1);

        div1.innerHTML += `
            <div class="form-check" name="modaloption">
                <input type="text" id=${name} placeholder="Ecrire ici" class="form-control" />
            </idv>
        `;


    }
}

function createcheckboxlabel() {
    let div1 = document.getElementById('modal_checkbox_label_'+questioninfo[0].id);

    div1.innerHTML = "";

    nombre = document.getElementById('modal_numbers_checkbox_'+questioninfo[0].id).value;
    for(let i = 0 ;i<nombre ;i++) {

        let name = "modal_checkbox_Q_"+questioninfo[0].id+"option_"+(i+1);

        div1.innerHTML += `
            <div class="form-check" name="modaloption">
                <input type="text" id=${name} placeholder="Ecrire ici" class="form-control" />
            </idv>
        `;


    }
}

function newquestion(data) {

    if(data[0].type == "text"){
       let titre = document.getElementById(data[0].attr_name);
       let divchange = document.getElementById("change_"+data[1].id);
       console.log(divchange.innerHTML);
       divchange.innerHTML = "";
       titre.innerHTML = data[1].title;
       divchange.innerHTML = `
            <input type="text" placeholder="votre reponse" class="form-control" />
       `;


    }else if(selectvalue == "email"){
        let titre = document.getElementById(data[0].attr_name);
        let divchange = document.getElementById("change_"+data[1].id);
        console.log(divchange.innerHTML);
        divchange.innerHTML = "";
        titre.innerHTML = data[1].title;
        divchange.innerHTML = `
                <input type="email" placeholder="E-mail" class="form-control" />
        `;
    }else if(selectvalue == "date"){
        let titre = document.getElementById(data[0].attr_name);
        let divchange = document.getElementById("change_"+data[1].id);
        console.log(divchange.innerHTML);
        divchange.innerHTML = "";
        titre.innerHTML = data[1].title;
        divchange.innerHTML = `
                <input type="date" class="form-control" />
        `;
    }else if(selectvalue == "fichier"){
        let titre = document.getElementById(data[0].attr_name);
        let divchange = document.getElementById("change_"+data[1].id);
        console.log(divchange.innerHTML);
        divchange.innerHTML = "";
        titre.innerHTML = data[1].title;
        divchange.innerHTML = `
                <input type="file" class="form-control" />
        `;
    }else if(selectvalue == "heure"){
        let titre = document.getElementById(data[0].attr_name);
        let divchange = document.getElementById("change_"+data[1].id);
        console.log(divchange.innerHTML);
        divchange.innerHTML = "";
        titre.innerHTML = data[1].title;
        divchange.innerHTML = `
                <input type="time" class="form-control" />
        `;
    }else if(selectvalue == "radio"){
        let titre = document.getElementById(data[0].attr_name);
        let divchange = document.getElementById("change_"+data[1].id);

        divchange.innerHTML = "";
        titre.innerHTML = data[1].title;

        for (let i = 0; i < nombre; i++) {

            let div2   = document.createElement("div");
            let radio = document.createElement("input");
            let label = document.createElement("label");

            div2.setAttribute("class","form-check");

            radio.setAttribute("name", "radio"+data[1].id);
            radio.setAttribute("type", "radio");
            radio.setAttribute("class", "form-check-input");
            radio.setAttribute("value", data[2][i].value);

            label.appendChild(radio);
            label.appendChild(document.createTextNode(data[2][i].value));

            div2.appendChild(label);
            divchange.appendChild(div2);
        }
    }else if(selectvalue == "checkbox"){
        let titre = document.getElementById(data[0].attr_name);
        let divchange = document.getElementById("change_"+data[1].id);

        divchange.innerHTML = "";
        titre.innerHTML = data[1].title;

        for (let i = 0; i < nombre; i++) {

            let div2   = document.createElement("div");
            let checkbox = document.createElement("input");
            let label = document.createElement("label");

            div2.setAttribute("class","form-check");

            checkbox.setAttribute("name", data[2][i].attr_name);
            checkbox.setAttribute("type", "checkbox");
            checkbox.setAttribute("class", "form-check-input");
            checkbox.setAttribute("value", data[2][i].value);

            label.appendChild(checkbox);
            label.appendChild(document.createTextNode(data[2][i].value));

            div2.appendChild(label);
            divchange.appendChild(div2);
        }
    }else if(selectvalue == "textarea"){
        let titre = document.getElementById(data[0].attr_name);
        let divchange = document.getElementById("change_"+data[1].id);
        console.log(divchange.innerHTML);
        divchange.innerHTML = "";
        titre.innerHTML = data[1].title;
        divchange.innerHTML = `
                <textarea col="30" row="2" class="form-control" placeholder="votre reponse"></textarea>
        `;
    }else if(selectvalue == "select"){
        let titre = document.getElementById(data[0].attr_name);
        let divchange = document.getElementById("change_"+data[1].id);

        let select = document.createElement("select");
        let div2   = document.createElement("div");
        div2.setAttribute("class","form-group");
        select.setAttribute("name", "reponse_"+data[1].id);
        select.setAttribute("class", "form-control");


        divchange.innerHTML = "";
        titre.innerHTML = data[1].title;

        for (let i = 0; i < nombre; i++) {



            let option = document.createElement("option");
            option.setAttribute("value", data[2][i].value);
            option.textContent =  data[2][i].value;




            select.appendChild(option);



        }

        div2.appendChild(select);
        divchange.appendChild(div2);
    }
}

function createselectlabel() {
    let div1 = document.getElementById('modal_select_label_'+questioninfo[0].id);

    div1.innerHTML = "";

    nombre = document.getElementById('modal_numbers_select_'+questioninfo[0].id).value;

    for(let i = 0 ;i<nombre ;i++) {
        let name = "modal_select_Q_"+questioninfo[0].id+"option_"+(i+1);

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



