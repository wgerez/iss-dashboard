<?php

class DatabaseSeeder extends Seeder {

 /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
 
        Eloquent::unguard();
   
        $this->call('ContactoTableSeeder');

        $this->call('EstadoCivilTableSeeder');

        $this->call('NivelEducativoTableSeeder');

        $this->call('OrganismoHabilitanteTableSeeder');

        $this->call('TipoDocumentoTableSeeder');

        $this->call('TipoCarreraTableSeeder');

        $this->call('RegimenTableSeeder');

        $this->call('TipoDuracionTableSeeder');

        $this->call('ModalidadTableSeeder');

        $this->call('AreaOcupacionalTableSeeder');

        $this->call('ModuloTableSeeder');
 
    }
}
 
//clase para insertar contactos
class ContactoTableSeeder extends Seeder {
 
    public function run()
    {
 
        DB::table('contactos')->insert(array(
            'Descripcion'=>'Particular'
        ));
 
        DB::table('contactos')->insert(array(
            'Descripcion'=>'Laboral'
        ));

        DB::table('contactos')->insert(array(
           'Descripcion'=>'Correo'
        ));   

        DB::table('contactos')->insert(array(
            'Descripcion'=>'Sitio Web'
        )); 
    }
}
 
//clase para insertar estado civil
class EstadoCivilTableSeeder extends Seeder {
 
    public function run()
    {
        DB::table('estadosciviles')->insert(array(
            'Descripcion'=>'Soltero'
        ));
    
        DB::table('estadosciviles')->insert(array(
            'Descripcion'=>'Casado'
        ));

        DB::table('estadosciviles')->insert(array(
            'Descripcion'=>'Divorciado'
        ));

        DB::table('estadosciviles')->insert(array(
            'Descripcion'=>'Viudo'
        ));

    }
}

//clase para insertar nivel educativo
class NivelEducativoTableSeeder extends Seeder {
 
    public function run()
    {
        DB::table('niveles_educativos')->insert(array(
            'Descripcion'=>'Terciario'
        ));
    
        DB::table('niveles_educativos')->insert(array(
            'Descripcion'=>'Universitario'
        ));

    }
}


//clase para insertar organismo habilitante
class OrganismoHabilitanteTableSeeder extends Seeder {
 
    public function run()
    {
        DB::table('organismoshabilitantes')->insert(array(
            'Descripcion'=>'Ministerio de Educación'
        ));

    }
}


//clase para insertar Tipo Documento
class TipoDocumentoTableSeeder extends Seeder {
 
    public function run()
    {
        DB::table('tipodocumentos')->insert(array(
            'Descripcion'=>'DNI'
        ));

        DB::table('tipodocumentos')->insert(array(
            'Descripcion'=>'DNID'
        ));

        DB::table('tipodocumentos')->insert(array(
            'Descripcion'=>'LE'
        ));

        DB::table('tipodocumentos')->insert(array(
            'Descripcion'=>'LC'
        ));


    }
}



//clase para insertar titulo habilitante
class TituloHabilitanteTableSeeder extends Seeder {
 
    public function run()
    {
        DB::table('tituloshabilitantes')->insert(array(
            'Descripcion'=>'Profesor de Ingles'
        ));

    }
}


//clase para insertar Tipo Carrera
class TipoCarreraTableSeeder extends Seeder {
 
    public function run()
    {
        DB::table('tiposcarreras')->insert(array(
            'Descripcion'=>'Pregrado'
        ));

        DB::table('tiposcarreras')->insert(array(
            'Descripcion'=>'Grado'
        ));

        DB::table('tiposcarreras')->insert(array(
            'Descripcion'=>'Posgrado'
        ));

        DB::table('tiposcarreras')->insert(array(
            'Descripcion'=>'Técnico Superior'
        ));
        
    }
}


//clase para insertar Regimen
class RegimenTableSeeder extends Seeder {
 
    public function run()
    {
        DB::table('regimenes')->insert(array(
            'Descripcion'=>'Mixto'
        ));

        DB::table('regimenes')->insert(array(
            'Descripcion'=>'Diferenciado'
        ));
        
    }
}


//clase para insertar  tipo duracion
class TipoDuracionTableSeeder extends Seeder {
 
    public function run()
    {
 
        DB::table('tiposduraciones')->insert(array(
            'Descripcion'=>'bimestre'
        ));
 
        DB::table('tiposduraciones')->insert(array(
            'Descripcion'=>'trimestre'
        ));

        DB::table('tiposduraciones')->insert(array(
           'Descripcion'=>'cuatrimestre'
        ));   

        DB::table('tiposduraciones')->insert(array(
            'Descripcion'=>'años'
        )); 
    }
}


//clase para insertar Modalidad
class ModalidadTableSeeder extends Seeder {
 
    public function run()
    {
 
        DB::table('modalidades')->insert(array(
            'Descripcion'=>'Presencial'
        ));
 
        DB::table('modalidades')->insert(array(
            'Descripcion'=>'No presencial'
        ));

        DB::table('modalidades')->insert(array(
           'Descripcion'=>'a distancia'
        ));   
    }
}



//clase para insertar AreaOcupacional
class AreaOcupacionalTableSeeder extends Seeder {
 
    public function run()
    {
 
        DB::table('areasocupacionales')->insert(array(
            'Descripcion'=>'Sistema de Salud Publica'
        ));
 
        DB::table('areasocupacionales')->insert(array(
            'Descripcion'=>'Informática'
        ));

    }
}


//clase para insertar Modulo
class ModuloTableSeeder extends Seeder {
 
    public function run()
    {
 
        DB::table('modulos')->insert(array(
            'Descripcion'=>'Todos'
        ));
 
        DB::table('modulos')->insert(array(
            'Descripcion'=>'Gestión Académica'
        ));

        DB::table('modulos')->insert(array(
            'Descripcion'=>'Gestión Administrativa'
        ));

        DB::table('modulos')->insert(array(
            'Descripcion'=>'Gestión Contable'
        ));

        DB::table('modulos')->insert(array(
            'Descripcion'=>'Configuraciones'
        ));

        DB::table('modulos')->insert(array(
            'Descripcion'=>'Seguridad'
        ));
    }
}