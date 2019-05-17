angular.module('practicamvc',['ngRoute'])
.run(["$rootScope", function(rs){
	rs.user_a_editar=[];
}])
.config(["$routeProvider",function(routeProvider){
	routeProvider
	.when("/login",{
		controller: "loginControl",
		templateUrl: "vistas/login.html"
	})
	.when("/home",{
		controller: "homeControl",
		templateUrl: "vistas/home.html"
	})
	.when("/alta_user",{
		controller: "altaControl",
		templateUrl: "vistas/alta_user.html"
	})
	.when("/user",{
		controller: "lista_userControl",
		templateUrl: "vistas/user.html"
	})
	.when("/edit_user",{
		controller: "edit_userControl",
		templateUrl: "vistas/edit_user.html"
	})
	.otherwise("/login")
}])
.controller('loginControl',[
	"$scope","$http",function(scope,http){
		//Codigo
		scope.sesion = function(){
			http.get("php/usuarios.php", {params: {usuario: scope.user, password: scope.pass}
			}).then(function(resp){
				//alert("Inició Sesión " + resp.data.nombre);
                location.href = "#!/home";
			},function(error){
				alert("Error en el nombre de usuario o contraseña");
			});
		};
	}
])
.controller('homeControl',["$scope","$http",function(scope,http){
}])
.controller('altaControl',["$scope","$http",function(scope,http){
    scope.guardar = function(){
    	var datos= new FormData();
    	datos.append("user",scope.user);
		datos.append("pass",scope.pass);
		datos.append("nombre",scope.nombre);
    	http.post("php/usuarios.php",datos,{
        headers: {
          'Content-Type':undefined
        }
    	})
    	.then(function(resp){
    	  console.log(resp);
          alert(resp.data.msg);
          location.href = '#!/home';
    	},function(error){
          alert("Error en servidor");
    	});
    };
              
}])
.controller('lista_userControl',["$scope","$http","$rootScope",function(scope,http,rs){//""
	scope.usuarios=[];
	scope.consulta = function(){
      http.get("php/usuarios.php")
     .then(function(r){
     	if (r.data.length > 0) {
     scope.usuarios = r.data;
     M.toast({html: 'datos obtenidos'});

     	}else{
     	M.toast({html: 'sin datos'});	
     	}
     
      },function(e){
      M.toast({html: 'Error en la conexion'});
      })
	};
    scope.consulta();

    scope.eliminar=function(user){
    scope.user_eliminar=user;//guarda el nombre del usuario
     $("#confirmar_eliminar").modal('open');
    };

    scope.sielimina = function(){
      http.delete("php/usuarios.php",
      	{params:{user:scope.user_eliminar}})
     .then(function(r){
     M.toast({html: r.data.msg});
      scope.consulta();
      },function(e){
      M.toast({html: 'Error en la conexion al eliminar'});
      })
	};

	scope.editar=function(user){
		rs.user_a_editar=user;
       location.href = "#!/edit_user"


	}
}])
.controller('edit_userControl',["$scope","$http","$rootScope",function(scope,http,rs){
	scope.user_a_editar = rs.user_a_editar;
	console.log(rs.user_a_editar);
}])