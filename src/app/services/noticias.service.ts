import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class NoticiasService {
  //private url = ' http://tsiete.com.mx/librosRincon_1/';
  private url = 'http://librosdelrincon.sep.gob.mx/php/';

  constructor(private http: HttpClient) {
        this.getNoticias();
  }


  getNoticias(){
  return this.http.get(
    `${this.url}noticias_full.php`
  );
  }


  createNoticias(noticia){

    const noticiaData = {
      "titulo": "noticia 1",
      "fecha": "29/01/2020",
      "noticia_url": "www.hola.com",
      "Publicada": "1"
    }
    return this.http.post(
      `${this.url}insert_noticia.php`, noticia
    );
    }

    updateNoticias(noticia){

      return this.http.post(
        `${this.url}update_noticia.php`, noticia
      );
      }
}
