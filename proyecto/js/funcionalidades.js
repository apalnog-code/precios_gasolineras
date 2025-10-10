document.addEventListener("DOMContentLoaded", main);

function main() {

    let section = document.querySelector("section");
    let btnMenuHamburguesa = document.querySelector("#menuHamburguesa span");
    let spanPerfil = document.querySelector("#perfil span");
    let divperfil = document.querySelector("#perfil div");
    let aside = document.querySelector("aside");
    let spanColorPuntosControl = document.querySelectorAll("span.color");

    if(btnMenuHamburguesa) {
        btnMenuHamburguesa.addEventListener("click", function() {
            if(section.classList == "nover") {
                section.classList.remove("nover");
                section.style.width = "20%";
                aside.style.width = "80%";
            } else {
                section.classList.add("nover");
                aside.style.width = "100%";
            }
        });
    }

    if(spanPerfil) {
        spanPerfil.addEventListener("click", function() {
            if(divperfil.classList == "nover") {
                divperfil.classList.remove("nover");
                divperfil.classList.add("visible");
            } else {
                divperfil.classList.remove("visible");
                divperfil.classList.add("nover");
            }
        });
    }

    spanColorPuntosControl.forEach(element => {
        let color = element.textContent;
        element.style.border = `2px solid ${color}`;
        element.classList.add("color");
    });


}