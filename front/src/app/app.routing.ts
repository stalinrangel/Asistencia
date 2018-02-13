import { NgModule } from '@angular/core';
import { CommonModule, } from '@angular/common';
import { BrowserModule  } from '@angular/platform-browser';
import { Routes, RouterModule } from '@angular/router';

import { AsistenciasComponent } from './asistencia/asistencias.component';
import { ListaComponent } from './lista/lista.component';
import { RutaService } from './services/ruta.service';
//import { UserProfileComponent } from './user-profile/user-profile.component';

const routes: Routes =[
    { path: '',                 redirectTo: '/asistencias', pathMatch: 'full' },
    { path: 'asistencias',      component: AsistenciasComponent, pathMatch: 'full'},
    { path: 'lista',      component: ListaComponent, pathMatch: 'full'},
    { path: '**',               redirectTo: '/asistencias' }
      
];

@NgModule({
  imports: [
    CommonModule,
    BrowserModule,
    RouterModule.forRoot(routes)
  ],
  exports: [
  ],
})
export class AppRoutingModule { }
