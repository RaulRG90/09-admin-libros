import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class LibrosService {
  //private url = ' http://tsiete.com.mx/librosRincon_1/';
  private url = 'http://librosdelrincon.sep.gob.mx/php/';

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
        
        return this.http.post(
          `${this.url}update_libro.php`, libro
        );
        }
}
