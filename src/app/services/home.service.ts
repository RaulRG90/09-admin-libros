import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class HomeService {
  //private url = ' http://tsiete.com.mx/librosRincon_1/';
  //private url = 'http://localhost/librosRincon/';
  private url = 'http://librosdelrincon.sep.gob.mx/php/'
  constructor( private http: HttpClient) { }
  
  subirImagen(datos:any):Observable<any>{
    return this.http.post(
      `${this.url}upploadfile.php`, datos
    );
  }

}
