document.addEventListener("DOMContentLoaded", main);

function main(){

    let selectProvincias = document.querySelector("#provincia");
    let selectLocalidades = document.querySelector("#localidad");

    function cargarProvincias(){

        let solicitud = crearSolicitud();
        let urlProvincias = `https://sedeaplicaciones.minetur.gob.es/ServiciosRESTCarburantes/PreciosCarburantes/Listados/Provincias/`;
        solicitud.open("GET", urlProvincias);

        solicitud.addEventListener("load", (e)=> {

            if(e.target.status == 200){

                let provincias = JSON.parse(solicitud.response);
                selectProvincias.innerHTML = "";

                let option = document.createElement("option");
                option.textContent = "--Selecciona una provincia--";
                selectProvincias.append(option);

                provincias.forEach(element => {
                    let option = document.createElement("option");
                    option.textContent = element.Provincia;
                    option.value = element.IDPovincia;
                    selectProvincias.append(option);
                });

            }

        });

        solicitud.send();

    }

    cargarProvincias();

        function cargarMunicipios(IDPROVINCIA){

        let solicitud = crearSolicitud();
        let urlLocalidades = `https://sedeaplicaciones.minetur.gob.es/ServiciosRESTCarburantes/PreciosCarburantes/Listados/MunicipiosPorProvincia/${IDPROVINCIA}`;
        solicitud.open("GET", urlLocalidades);

        solicitud.addEventListener("load", (e)=> {

            if(e.target.status == 200){

                let localidades = JSON.parse(solicitud.response);
                selectLocalidades.innerHTML = ""

                localidades.forEach(element => {
                    let option = document.createElement("option");
                    option.textContent = element.Municipio;
                    option.value = element.IDMunicipio;
                    option.id = element.Municipio;
                    selectLocalidades.append(option);
                });

            }

        });

        solicitud.send();

    }


    selectProvincias.addEventListener("change", function(){
        cargarMunicipios(selectProvincias.value);
    });
    

    selectProvincias.addEventListener("change", function () {
        let idProvincia = this.value;
        if (idProvincia) {
            cargarMunicipios(idProvincia);
        }

        let nombreProvincia = this.options[this.selectedIndex].text;
        let inputProvinciaOculta = document.querySelector("#provinciaoculta");
        if (inputProvinciaOculta) {
            inputProvinciaOculta.value = nombreProvincia;
        }
    });

    selectLocalidades.addEventListener("change", function () {
        let nombreLocalidad = this.options[this.selectedIndex].text;
        let inputLocalidadOculta = document.querySelector("#localidadoculta");
        if (inputLocalidadOculta) {
            inputLocalidadOculta.value = nombreLocalidad;
        }
    });
}


function crearSolicitud(){

    let solicitud;
    try {
        solicitud = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("microsoftXMLHTTP");
    } catch (error) {
        alert(error);
    }

    return solicitud;

}