angular.module('practicamvc',['ngRoute'])
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