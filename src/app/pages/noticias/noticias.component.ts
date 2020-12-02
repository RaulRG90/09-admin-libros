import { Component, OnInit } from '@angular/core';
import { NoticiasService } from 'src/app/services/noticias.service';
import Swal from 'sweetalert2/dist/sweetalert2.js';
//Angular 2 está obsoleto 

@Component({
  selector: 'app-noticias-mes',
  templateUrl: './noticias.component.html',
  styleUrls: ['./noticias.component.css']
})
export class NoticiasComponent implements OnInit {
  public listanoticias: {};
  p: number = 1;
  noticia: any;
  is_valid = false;
  constructor( private noticiasService: NoticiasService ) {
          this.noticia = {titulo: '', fecha: '', noticia_url: '', Publicada: 1}
  }
  // tslint:disable-next-line: typedef
  ngOnInit() {
    this.noticias();
  } 
  // tslint:disable-next-line: typedef
  save() {
    console.log(this.noticia)
  }
  // tslint:disable-next-line: typedef
  noticias() {
    this.noticiasService.getNoticias().subscribe(
      res => {
        this.listanoticias = res;
        console.log(res);
        // console.log(JSON.stringify(res));
      },
      err => {
        alert("No se encuentra el listado");
        // console.log(JSON.stringify(err));
      }
    );
  }
   //insertar noticias, mensaje de si hubo e
// tslint:disable-next-line: typedef
insertarNoticias() {
  if(this.isValid()){
    this.noticiasService.createNoticias(this.noticia).subscribe(
      res => {
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Registro guardado',
          showConfirmButton: false,
          timer: 1500
        });
        this.listanoticias = res; //arreglo actualizado
        this.noticia = { Publicada: 1};
        console.log(res);
        // console.log(JSON.stringify(res));
      },
      err => {
        alert("No se pudo crear el registro");
        // console.log(JSON.stringify(err));
      }
    );
  }else {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Todos los datos son requeridos',
      showConfirmButton: false,
      timer: 1500
    });
  }
    
  }

  // tslint:disable-next-line: typedef
  openUpdateModal(item){
    console.log(item);
    
    this.noticia = item;
    this.noticia.Publicada= item.publicada;
    console.log(this.noticia);

  }

  recoverData(){
    
    this.noticias()
    this.noticia ={ Publicada: 1}
  }

  cleanData (){
    this.noticia ={ Publicada: 1}
  }

  isValid(){
    if(this.noticia.titulo && this.noticia.fecha && this.noticia.noticia_url ) 
     return true;
     else 
     return false;
  }

  // tslint:disable-next-line: typedef
  actualizarNoticias() {
    // tslint:disable-next-line: radix
    this.noticia.Publicada = parseInt( this.noticia.Publicada )
    this.noticiasService.updateNoticias(this.noticia).subscribe(
      res => {
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Registro actualizado',
          showConfirmButton: false,
          timer: 1500
        });
        this.listanoticias = res; //arreglo actualizado
        console.log(res);
        this.noticia = {titulo: '', fecha: '', noticia_url: '', Publicada: 1}
        // console.log(JSON.stringify(res));
      },
      err => {
        alert("No se pudo actualizar el registro");
        // console.log(JSON.stringify(err));
      }
    );
  }

  // tslint:disable-next-line: member-ordering
  key: string = 'id';
  reverse: boolean = false;
  // tslint:disable-next-line: typedef
  sort(key){
    this.key = key;
    this.reverse = !this.reverse;
  }
}



