import { Component } from '@angular/core';
import { HttpClient, HttpParams  } from '@angular/common/http';
import { WebCamComponent } from 'ack-angular-webcam';
import { ArchwizardModule } from 'ng2-archwizard';
import * as moment from 'moment'; // add this 1 of 4
import { RutaService } from '../services/ruta.service';

@Component({
  //selector: 'app-root',
  templateUrl: './asistencias.component.html',
  styleUrls: ['./asistencias.component.css']
})
export class AsistenciasComponent {
  title = 'app';
  webcam:WebCamComponent//will be populated by <ack-webcam [(ref)]="webcam">
  base64
  image


  mime : string = 'image/jpeg'

  public ver=false;
  public legajo:any="";
  public personal:any=[];
  public persona:any;
  public camara=true;
  
  public now = moment();
  public hora:any;
  constructor(private http: HttpClient, private ruta: RutaService) {
   
  }
  ngOnInit(): void {
    //setInterval(this.update, 1000);http://vivoargentina.com/asistencia/backend/public/
    //this.http.get('https://vivoargentina.com/asistencia/backend/public/personal')
    //this.http.get('http://localhost/asistencias/backend/public/personal')
   
    this.http.get(this.ruta.get_ruta()+'/personal')
     .toPromise()
     .then(
     data => {
        this.personal=data;
        console.log(this.personal);
      },
     msg => { 
       console.log(msg);
     });
    }
  update() {
   this.now = moment();
   this.hora= this.now.format();
   console.log(this.hora);
  }

  getlegajo(){
    for (var i = 0; i < this.personal.length; i++) {
      if(this.legajo!='') {
        if(this.personal[i].LEGAJO==this.legajo) {
          console.log(this.legajo);
          this.persona=this.personal[i];
          this.ver=true;
          this.now = moment();
          this.hora= this.now.format();
          console.log(this.hora);
        }
      }
      
    }
  }
  atras(){
    this.ver=false;
    this.hora="";
    //setInterval(this.update, 1);
  }

   genBase64(){
    this.webcam.getBase64(this.mime)
    .then( base=>this.base64=base)
    .catch( e=>console.error(e) )
    this.camara=false;
  }
  volverCamara(){
    this.camara=true;
  }

  //get HTML5 FormData object and pretend to post to server
  genPostData(){
    console.log(this.webcam);
    this.webcam.captureAsFormData({fileName:'file.jpg'})
    .then( formData=>this.postFormData(formData) )
    .catch( e=>console.error(e) )
  }

  postFormData(formData){
    console.log(formData);
    }

     onCamError(err){
       console.log(err);
     }

    onCamSuccess(e){
      console.log(e);
    }

    print(){
    console.log(this.persona);
    var send = {
      imagen: JSON.stringify(this.base64),
      identifica:this.persona.IDENTIFICA,
      legajo:this.persona.LEGAJO,
      hora:JSON.stringify(this.hora),
      ruta:this.ruta.get_ruta()
    }
    console.log(send);
    //this.http.post('https://vivoargentina.com/asistencia/backend/public/asistencia',send)
    this.http.post(this.ruta.get_ruta()+'/asistencia',send)
     .toPromise()
     .then(
     data => {
        console.log(data);
        alert('Éxito');
        this.ver=false;
        this.camara=true;
        this.hora="";
        this.legajo="";
      },
     msg => { 
       console.log(msg.error);
     });

    }


}
