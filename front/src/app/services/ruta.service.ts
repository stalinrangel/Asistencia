import { Injectable } from '@angular/core';

@Injectable()
export class RutaService {

  //public ruta_servidor="https://vivoargentina.com/asistencia/backend/public/";
  public ruta_servidor="http://localhost/asistencias/backend/public/"; //Local stalin
  //public ruta_servidor="http://localhost/gitHub/cueto/cuetoAPI/"; //Local Freddy

  constructor() { }

  get_ruta(){
  	return this.ruta_servidor;
  }

}
