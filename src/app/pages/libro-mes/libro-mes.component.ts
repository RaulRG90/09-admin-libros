import { Component, OnInit } from '@angular/core';
import { LibrosService } from 'src/app/services/libros.service';
import { HomeService } from '../../services/home.service';

import Swal from 'sweetalert2/dist/sweetalert2.js';

@Component({
  selector: 'app-libro-mes',
  templateUrl: './libro-mes.component.html',
  styleUrls: ['./libro-mes.component.css']
})
export class LibroMesComponent implements OnInit {
  public listalibros: {};
  p: number = 1;
  libro: any;
  image: any;
  image_name: any
  loader: Boolean = false;
  constructor(
    private librosService: LibrosService,
    private subir: HomeService
  ) {
    this.libro = { publicado: 1 }
  }
  ngOnInit() {
    this.libros();
    //this.insertarLibros();
  }

  libros() {
    this.librosService.getLibros().subscribe(
      res => {
        this.listalibros = res;
        //console.log(res);
        // console.log(JSON.stringify(res));
      },
      err => {
        alert("No se encuentra el Listado");
        //console.log(JSON.stringify(err));
      }
    );
  }
  //insertar noticias, mensaje de si hubo e
  insertarLibros() {
    this.librosService.createLibros(this.libro).subscribe(
      res => {
        this.listalibros = res; //arreglo actualizado
        console.log(res);
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Registro guardado',
          showConfirmButton: false,
          timer: 1500
        });
        this.libro = { publicado: 1 }
        // console.log(JSON.stringify(res));
      },
      err => {
        alert("no se pudo crear el regsitro");
        //console.log(JSON.stringify(err));
      }
    );
  }

  openUpdateModal(item) {
    //console.log(item);

    this.libro = item

  }

  recoverData(){
    
    this.libros()
    this.libro = {publicado: 1}
  }

  cleanData (){
    this.libro = {publicado: 1}
  }

  actualizarLibros() {
    //this.libro.img = this.image_name;
    //console.log(this.libro);
    this.librosService.updateLibros(this.libro).subscribe(
      res => {
        this.listalibros = res; //arreglo actualizado
        //console.log(res);
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Registro actualizado',
          showConfirmButton: false,
          timer: 1500
        });
        this.libro = { publicado: 1 }
        // console.log(JSON.stringify(res));
      },
      err => {
        alert("No se pudo actualizar el registro");
        //console.log(JSON.stringify(err));
      }
    );
  }


  key: string = 'id';
  reverse: boolean = false;
  sort(key) {
    this.key = key;
    this.reverse = !this.reverse;
  }

 
  subiendoando(ev) {
    this.image = ev.target;

    if (this.image.files.length > 0) {
      let sizeByte = this.image.files[0].size;
      let siezekiloByte = parseInt(sizeByte) / 1024;

      if (siezekiloByte > 1000) {

        (<HTMLInputElement>document.getElementById('imageId')).value = '';

        alert('El tamaño supera el limite permitido');

      } else {
        let file = this.image.files[0]
        let newThis = this
        let image = new Image()
        image.src = URL.createObjectURL(file)
        image.addEventListener('load',function(img){
          //console.log(this.width)
          if(this.width <=350 && this.height <=500){
            let form = new FormData();
            form.append('file',file);
            newThis.subir.subirImagen(form).subscribe(
              resp => {
                if (resp.status) {
                  //console.log(resp);
                  newThis.image_name = resp.generatedName;
                  newThis.libro.img = resp.url + resp.generatedName;
                }
              },
              error => {
                alert('Imagen supera el tamaño permitido, porfavor ingrese una imagen que no sobrepase 350px X 500px');
    
              }
            );
          }else{
            (<HTMLInputElement>document.getElementById('imageId')).value = '';
            alert("Las dimensiones de la imagen no deben de sobrepasar los 350px de ancho y 500px de alto")
            
          }
        })
       
      }
    }
  }
}

