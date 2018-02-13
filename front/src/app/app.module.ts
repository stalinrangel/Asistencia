import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { HttpClientModule } from '@angular/common/http';
import { WebCamModule } from 'ack-angular-webcam';
import { ArchwizardModule } from 'ng2-archwizard';
import { FormsModule } from '@angular/forms';
import { RouterModule } from '@angular/router';
import { AppComponent } from './app.component';
import { AppRoutingModule } from './app.routing';
import { ModalModule } from 'ngx-bootstrap/modal';

import { RutaService } from './services/ruta.service';
import { AsistenciasComponent } from './asistencia/asistencias.component';
import { ListaComponent } from './lista/lista.component';

@NgModule({
  declarations: [
    AppComponent,
    AsistenciasComponent,
    ListaComponent
  ],
  imports: [
    BrowserModule,
    WebCamModule,
    HttpClientModule,
    ArchwizardModule,
    FormsModule,
    AppRoutingModule,
    RouterModule,
    ModalModule.forRoot(),
  ],
  providers: [
    RutaService,
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
