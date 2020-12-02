import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class HomeService {
  
  //private url = 'http://librosdelrincon.sep.gob.mx/php/'
  private url = 'https://tsiete.com.mx/LibrosDelRinconIMG/';
  constructor( private http: HttpClient) { }
  
  subirImagen(datos:any):Observable<any>{
    return this.http.post(
      `${this.url}upploadfile.php`, datos
    );
  }

}
