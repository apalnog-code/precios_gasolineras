document.addEventListener("DOMContentLoaded", main);

function main(){

    let divComunidad = document.querySelector("#divComunidad");
    let selectComunidades = document.createElement("select");

    let divProvincia = document.querySelector("#divProvincia");
    let selectProvincias = document.createElement("select");

    let divLocalidad = document.querySelector("#divLocalidad");
    let selectLocalidades = document.createElement("select");

    let btnEnviar = document.querySelector("button");
    let tbbody = document.querySelector("table tbody");

    function cargarComunidadesutonomas(){

        let urlComunidades = `https://sedeaplicaciones.minetur.gob.es/ServiciosRESTCarburantes/PreciosCarburantes/Listados/ComunidadesAutonomas/`;
        let solicitud = crearSolicitud();

        solicitud.open("GET", urlComunidades);
        solicitud.addEventListener("load", (e) => {

            if(e.target.status == 200){

                let comunidades = JSON.parse(solicitud.response);
                selectComunidades.innerHTML = "";

                comunidades.forEach(element => {
                    
                    let option = document.createElement("option");
                    option.textContent = element.CCAA;
                    option.value = element.IDCCAA;
                    selectComunidades.append(option);

                });

                divComunidad.append(selectComunidades);
                cargarProvincias(selectComunidades.value);

            }

        });

        solicitud.send();

    }

    cargarComunidadesutonomas();

    function cargarProvincias(IDCCAA){

        let urlProvincias = `https://sedeaplicaciones.minetur.gob.es/ServiciosRESTCarburantes/PreciosCarburantes/Listados/ProvinciasPorComunidad/${IDCCAA}`
        let solicitud = crearSolicitud();

        solicitud.open("GET", urlProvincias);
        solicitud.addEventListener("load", (e) => {

            if(e.target.status == 200){

                let provincias = JSON.parse(solicitud.response);
                selectProvincias.innerHTML = "";

                provincias.forEach(element => {
                    
                    let option = document.createElement("option");
                    option.textContent = element.Provincia;
                    option.value = element.IDPovincia;
                    selectProvincias.append(option);

                });

                divProvincia.append(selectProvincias);
                cargarLocalidades(selectProvincias.value);

            }

        });

        solicitud.send();

    }


    function cargarLocalidades(IDPROVINCIA){

        let urllocalidades = `https://sedeaplicaciones.minetur.gob.es/ServiciosRESTCarburantes/PreciosCarburantes/Listados/MunicipiosPorProvincia/${IDPROVINCIA}`
        let solicitud = crearSolicitud();

        solicitud.open("GET", urllocalidades);
        solicitud.addEventListener("load", (e) => {

            if(e.target.status == 200){

                let localidades = JSON.parse(solicitud.response);
                selectLocalidades.innerHTML = "";

                localidades.forEach(element => {
                    
                    let option = document.createElement("option");
                    option.textContent = element.Municipio;
                    option.value = element.IDMunicipio;
                    selectLocalidades.append(option);

                });

                divLocalidad.append(selectLocalidades);

            }

        });

        solicitud.send();

    }

    function cargarDatos(IDMUNICIPIO){

        let urlgasolineras = `https://sedeaplicaciones.minetur.gob.es/ServiciosRESTCarburantes/PreciosCarburantes/EstacionesTerrestres/FiltroMunicipio/${IDMUNICIPIO}`;
        let solicitud = crearSolicitud();

        solicitud.open("GET", urlgasolineras);
        solicitud.addEventListener("load", (e) => {

            if(e.target.status == 200){

                let gasoineras = JSON.parse(solicitud.response);
                tbbody.innerHTML = "";

                        gasoineras.ListaEESSPrecio.forEach(element => {
                        
                        let tr = document.createElement("tr");
                        let rotulo = rellenarFilas(element.Rótulo);
                        let direccion = rellenarFilas(element.Dirección);
                        let horario = rellenarFilas(element.Horario);
                        let gas95 = rellenarFilas(element["Precio Gasolina 95 E10"] || "- - -");
                        let gas98 = rellenarFilas(element["Precio Gasolina 98 E10"] || "- - -");
                        let gasA = rellenarFilas(element["Precio Gasoleo A"] || "- - -");
                        let basB = rellenarFilas(element["Precio Gasoleo B"] || "- - -");
                        let gasPremium = rellenarFilas(element["Precio Gasoleo Premium"] || "- - -");
                        tr.append(rotulo, direccion, horario, gas95, gas98, gasA, basB, gasPremium);
                        tbbody.append(tr);

                    });


            }

        });

        solicitud.send();

    }


    selectComunidades.addEventListener("change", function(){
        cargarProvincias(selectComunidades.value);
    });

    selectProvincias.addEventListener("change", function(){
        cargarLocalidades(selectProvincias.value);
    });

    if(btnEnviar){
        btnEnviar.addEventListener("click", function(e){
            e.preventDefault();
            cargarDatos(selectLocalidades.value);
        });
    }


}

function crearSolicitud(){

    let solicitud;
    try {
    
        solicitud = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("MicrosoftXMLHTTP");
    } catch (error) {
        alert(error);
    }

    return solicitud;

}


function rellenarFilas(contenido){

    if(contenido){

        let td = document.createElement("td");
        td.textContent = contenido;
        return td;

    }

    return null;

}