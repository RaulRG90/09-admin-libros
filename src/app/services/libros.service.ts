import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class LibrosService {
  //private url = ' http://tsiete.com.mx/librosRincon_1/';
  private url = 'http://librosdelrincon.sep.gob.mx/php_1/';

    constructor(private http: HttpClient) { 
     this.getLibros();
     //this.createLibros();
     //this.updateLibros();
    }

    getLibros(){
      return this.http.get(
        `${this.url}libros_mes_full.php`
      )
    }

    createLibros(libro){
      //libro.img = "imagen cul";
      //libro.coedicion = "SEP"
      return this.http.post(
        `${this.url}insert_libro.php`, libro
      );
      }
  
      updateLibros(libro){
        //console.log(libro);
        /*const librosData = {
          "id": libro.id,
          "titulo": libro.autor,
          "edicion": libro.edicion,
          "pais": libro.pais,
          "anio": libro.anio,
          "paginas": libro.pagina,
          "autor": libro.actualizado,
          "publicado": libro.publicado,
          "coedicion" : libro.coedicion,
          "img" : libro.img,
          "resena" : libro.resena
        }*/
        return this.http.post(
          `${this.url}update_libro.php`, libro
        );
        }
}
