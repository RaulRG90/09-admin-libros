import { Component, OnInit } from '@angular/core';
import { HomeService } from '../../services/home.service';
@Component({
  selector: 'app-subirarchivos',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {
  trueimg:Boolean = false;
  loader:Boolean = false;
  myimg:string;
  final:Boolean = true;
  msn:string;
  constructor(private subir: HomeService) { }
  ngOnInit() {
    this.msn = "Subir una imagen no mayor de 1MB";
  }
  
  subiendoando(ev){
    let img:any = ev.target;
    if(img.files.length > 0){
      this.loader = true;
      let form = new FormData();
      form.append('file',img.files[0]);
      this.subir.subirImagen(form).subscribe(
        resp => {
          this.loader = false;
          if(resp.status){
            this.trueimg = true;
            this.msn = "Gracias por visitar unprogramador.com"
          }
        },
        error => {
          this.loader = false;
          alert('Imagen supera el tamaño permitido');
          
        }
      );
    }
  }
}