<!DOCTYPE html>
<html lang="es">
	<head>
		<title>ISS - Informes</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	</head>
	<style> 
	    body { font-family: Arial, Helvetica;}

	    section{ margin-top: 0.7em} 
	    footer {
	       position:fixed;
	       left:0;
	       bottom:0;
	       height:20px;
	       width:100%;
	       font-size:12px;
	       padding-top: 0.4em;
	       border-top: 1px solid #DADADA;
	    }
	    footer .pagenum:before {/*AGREGUE 17-04-19 */
		    content: counter(page);
		}/* HASTA AQUI */
	    table {
	      width: 100%;
	      color:black;
	      font-size:14px;
	      font-family: Arial, Helvetica;
	      margin-top: 0.7em;
	    }
	    thead {
	      background-color: #F5F5F5;
	    }
	    tbody {
	      background-color: #ffffff;     
	    }
	    th,td {
	      padding: 3pt;
	      border-bottom: 1px solid #A3A3A3;
	    }           
	    table{
	      border-collapse: collapse;
	      border-bottom: 1px solid #A3A3A3;
	    }
	    table th {
	      border-bottom: 1px solid #6B8397;
	    }   
	  </style>
	<body>
    	<header>
    		<img src="<?php echo $_SERVER["DOCUMENT_ROOT"].'/assets/global/img/encabezado.png'; ?>" alt="encabezado">
    	</header>		

		<section>
			@yield('cuerpo')
		</section>

		<!--footer>
			<center>Instituto Superior de Sanidad "Prof. Ramón Carrillo" - Formosa</center>
		</footer -->
		<br><!-- AGREGUE 17-04-19 -->
		<br>
		<br>
		<footer>
            <div class="pagenum-container">Pagina <span class="pagenum"></span></div>
		</footer><!-- HASTA AQUI -->
	</body>
</html>