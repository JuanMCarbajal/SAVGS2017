// script/validacion.js
var redondeo = function(num){
	if(String(num).length > 5)
		num = Math.round(num*100)/100;
	else
		if(String(num).length > 2)
			num.toFixed(2);
	return num;
};

var existe = function(id){
	if($("#"+id).val()=="")
	{	if(!$("#"+id+"error").length)
			$("#"+id).after("<span id='"+id+"error' class='error'> requerido</span>");
		else
			if ($("#"+id+"error").html().indexOf(" requerido") < 0)
				$("#"+id+"error").append(" requerido");
	return false;
	}
	if($("#"+id+"error").length)
	{
		if ($("#"+id+"error").html().indexOf(" requerido") >= 0)
		{	var str=$("#"+id+"error").html().replace(" requerido","");
			$("#"+id+"error").html(str);
		}
	}
	return true;
	};	

var radioChecked = function(id1,id2){
	if(!$("#"+id1).is(":checked")&&!$("#"+id2).is(":checked"))
	{	if(!$("#"+id2+"error").length)
			$("#"+id2).next().after("<span id='"+id2+"error' class='error'> requerido</span>");
		else
			if ($("#"+id2+"error").html().indexOf(" requerido") < 0)
				$("#"+id2+"error").append(" requerido");
	return false;
	}
	if($("#"+id2+"error").length)
	{
		if ($("#"+id2+"error").html().indexOf(" requerido") >= 0)
		{	var str=$("#"+id2+"error").html().replace(" requerido","");
			$("#"+id2+"error").html(str);
		}
	}
	return true;
	};		
	
var esNumeroReal = function(id){
	if(isNaN($("#"+id).val()))
	{	if(!$("#"+id+"error").length)
			$("#"+id).after("<span id='"+id+"error' class='error'> solo numerico</span>");
		else
			if ($("#"+id+"error").html().indexOf(" solo numerico") < 0)
				$("#"+id+"error").append(" solo numerico");
	return false;
	}
	if($("#"+id+"error").length)
	{
		if ($("#"+id+"error").html().indexOf(" solo numerico") >= 0)
		{	var str=$("#"+id+"error").html().replace(" solo numerico","");
			$("#"+id+"error").html(str);
		}
	}
	return true;
	};	
	
var esDigito = function(id){
	if($("#"+id).val()!="")
	{
		if(!$("#"+id).val().match(/^\d*$/))
		{	if(!$("#"+id+"error").length)
				$("#"+id).after("<span id='"+id+"error' class='error'> solo digitos</span>");
			else
				if ($("#"+id+"error").html().indexOf(" solo digitos") < 0)
					$("#"+id+"error").append(" solo digitos");
		return false;
		}
		if($("#"+id+"error").length)
		{
			if ($("#"+id+"error").html().indexOf(" solo digitos") >= 0)
			{	var str=$("#"+id+"error").html().replace(" solo digitos","");
				$("#"+id+"error").html(str);
			}
		}
	}
	return true;
	};	
	
var esFecha =  function(id){
	if($("#"+id).val()!="")
	{
		if(!$("#"+id).val().match(/^([0][1-9]|[12][0-9]|3[01])(\/|-)([0][1-9]|[1][0-2])\2(\d{4})$/))
		{	if(!$("#"+id+"error").length)
				$("#"+id).after("<span id='"+id+"error' class='error'> fecha invalida</span>");
			else
				if ($("#"+id+"error").html().indexOf(" fecha invalida") < 0)
					$("#"+id+"error").append(" fecha invalida");
		return false;
		}
		if($("#"+id+"error").length)
		{
			if ($("#"+id+"error").html().indexOf(" fecha invalida") >= 0)
			{	var str=$("#"+id+"error").html().replace(" fecha invalida","");
				$("#"+id+"error").html(str);
			}
		}
	}
	return true;
	};	
	
	
var esPalabra =  function(id){
	if($("#"+id).val()!="")
	{
		if(!$("#"+id).val().match(/([A-Za-z\s0-9\.áéíóúÁÉÍÓÚ])$/))
		{	if(!$("#"+id+"error").length)
				$("#"+id).after("<span id='"+id+"error' class='error'> solo carateres y digitos</span>");
			else
				if ($("#"+id+"error").html().indexOf(" solo carateres y digitos") < 0)
					$("#"+id+"error").append(" solo carateres y digitos");
		return false;
		}
		if($("#"+id+"error").length)
		{
			if ($("#"+id+"error").html().indexOf(" solo carateres y digitos") >= 0)
			{	var str=$("#"+id+"error").html().replace(" solo carateres y digitos","");
				$("#"+id+"error").html(str);
			}
		}
	}
	return true;
	};		
	
var esNombre =  function(id){
	if($("#"+id).val()!="")
	{
		if(!$("#"+id).val().match(/([A-Za-z\s])$/))
		{	if(!$("#"+id+"error").length)
				$("#"+id).after("<span id='"+id+"error' class='error'> solo carateres</span>");
			else
				if ($("#"+id+"error").html().indexOf(" solo carateres") < 0)
					$("#"+id+"error").append(" solo carateres");
		return false;
		}
		if($("#"+id+"error").length)
		{
			if ($("#"+id+"error").html().indexOf(" solo carateres") >= 0)
			{	var str=$("#"+id+"error").html().replace(" solo carateres","");
				$("#"+id+"error").html(str);
			}
		}
	}
	return true;
	};		
	
	
var esMasDeUnChar =  function(id){
	if($("#"+id).val()!="")
	{
		if($("#"+id).val().length<2)
		{	if(!$("#"+id+"error").length)
				$("#"+id).after("<span id='"+id+"error' class='error'> mas de un caracter</span>");
			else
				if ($("#"+id+"error").html().indexOf(" mas de un caracter") < 0)
					$("#"+id+"error").append(" mas de un caracter");
		return false;
		}
		if($("#"+id+"error").length)
		{
			if ($("#"+id+"error").html().indexOf(" mas de un caracter") >= 0)
			{	var str=$("#"+id+"error").html().replace(" mas de un caracter","");
				$("#"+id+"error").html(str);
			}
		}
	}
	return true;
	};		

var esMasDeCeroChar =  function(id){
	if($("#"+id).val()!="")
	{
		if($("#"+id).val().length<1)
		{	if(!$("#"+id+"error").length)
				$("#"+id).after("<span id='"+id+"error' class='error'> Tiene que haber al menos un caracter</span>");
			else
				if ($("#"+id+"error").html().indexOf(" Tiene que haber al menos un caracter") < 0)
					$("#"+id+"error").append(" Tiene que haber al menos un caracter");
		return false;
		}
		if($("#"+id+"error").length)
		{
			if ($("#"+id+"error").html().indexOf(" Tiene que haber al menos un caracter") >= 0)
			{	var str=$("#"+id+"error").html().replace(" Tiene que haber al menos un caracter","");
				$("#"+id+"error").html(str);
			}
		}
	}
	return true;
	};	

var esBusquedaValida =  function(id){
	if($("#"+id).val()!="")
	{
		if(!$("#"+id).val().match(/^\d*$/))
		{	
		if($("#"+id).val().match(/([A-Za-z\s0-9\.])$/))
		{				
			if(!esMasDeUnChar(id))
				return false;
		}
		else
		{
			if(!$("#"+id+"error").length)
					$("#"+id).next().after("<span id='"+id+"error' class='error'> caracteros y/o digitos</span>");
				else
					if ($("#"+id+"error").html().indexOf(" caracteros y/o digitos") < 0)
						$("#"+id+"error").append(" caracteros y/o digitos");
			return false;
			}
			if($("#"+id+"error").length)
			{
				if ($("#"+id+"error").html().indexOf(" caracteros y/o digitos") >= 0)
				{	var str=$("#"+id+"error").html().replace(" caracteros y/o digitos","");
					$("#"+id+"error").html(str);
				}
			}
		}
		
	}
	else
		return false;
	if($("#"+id+"error").length)
		{
			if ($("#"+id+"error").html().indexOf(" caracteros y/o digitos") >= 0)
			{	var str=$("#"+id+"error").html().replace(" caracteros y/o digitos","");
				$("#"+id+"error").html(str);
			}
		}
	return true;
	};	
	
var existeVendedor = function(nro,tipo,cuil,codigo){
	var existe=false;
	$.ajax({
						type:'post',
						url:'existevendedor.php',
						async:false,
						data:{'nro' : $("#"+nro).val() , 'tipo' : $("#"+tipo).val(), 'cuil' : $("#"+cuil).val()  , 'codigo' : codigo },
						success:function(respuesta){
							if(respuesta=='true')
							{	existe = true;
							if(!$("#"+nro+"error").length)
							{	
								$("#"+nro).after("<span id='"+nro+"error' class='error'> vendedor existente</span>");
								$("#"+tipo).after("<span id='"+tipo+"error' class='error'> vendedor existente</span>");
								$("#"+cuil).after("<span id='"+cuil+"error' class='error'> vendedor existente</span>");
							}
							else
								if ($("#"+nro+"error").html().indexOf(" vendedor existente") < 0)
								{
									$("#"+nro+"error").append(" vendedor existente");
									$("#"+tipo+"error").append(" vendedor existente");
									$("#"+cuil+"error").append(" vendedor existente");
								}
							}
							else
							{
							if($("#"+nro+"error").length)
							{
								if ($("#"+nro+"error").html().indexOf(" vendedor existente") >= 0)
								{	var str1=$("#"+nro+"error").html().replace(" vendedor existente","");
									$("#"+nro+"error").html(str1);
									var str2=$("#"+tipo+"error").html().replace(" vendedor existente","");
									$("#"+tipo+"error").html(str2);
									var str3=$("#"+cuil+"error").html().replace(" vendedor existente","");
									$("#"+cuil+"error").html(str3);
								}
							}
							}
						}
					});
		return existe;
				};

var existeCliente = function(nro,tipo,cuil,codigo){
	var existe=false;
	$.ajax({
						type:'post',
						url:'existecliente.php',
						async:false,
						data:{'nro' : $("#"+nro).val() , 'tipo' : $("#"+tipo).val(), 'cuil' : $("#"+cuil).val()  , 'codigo' : codigo },
						success:function(respuesta){
							if(respuesta=='true')
							{	existe = true;
							if(!$("#"+nro+"error").length)
							{	
								$("#"+nro).after("<span id='"+nro+"error' class='error'> cliente existente</span>");
								$("#"+tipo).after("<span id='"+tipo+"error' class='error'> cliente existente</span>");
								$("#"+cuil).after("<span id='"+cuil+"error' class='error'> cliente existente</span>");
							}
							else
								if ($("#"+nro+"error").html().indexOf(" cliente existente") < 0)
								{
									$("#"+nro+"error").append(" cliente existente");
									$("#"+tipo+"error").append(" cliente existente");
									$("#"+cuil+"error").append(" cliente existente");
								}
							}
							else
							{
							if($("#"+nro+"error").length)
							{
								if ($("#"+nro+"error").html().indexOf(" cliente existente") >= 0)
								{	var str1=$("#"+nro+"error").html().replace(" cliente existente","");
									$("#"+nro+"error").html(str1);
									var str2=$("#"+tipo+"error").html().replace(" cliente existente","");
									$("#"+tipo+"error").html(str2);
									var str3=$("#"+cuil+"error").html().replace(" cliente existente","");
									$("#"+cuil+"error").html(str3);
								}
							}
							}
						}
					});
		return existe;
				};

var existeMedioPago = function(nombre, codigo){
	var existe=false;
	$.ajax({
						type:'post',
						url:'existemediopago.php',
						async:false,
						data:{'nombre' : $("#"+nombre).val() , 'codigo' : codigo },
						success:function(respuesta){
							if(respuesta=='true')
							{	existe = true;
							if(!$("#"+nombre+"error").length)
								$("#"+nombre).after("<span id='"+nombre+"error' class='error'> medio de pago existente</span>");
							else
								if ($("#"+nombre+"error").html().indexOf(" medio de pago existente") < 0)
									$("#"+nombre+"error").append(" medio de pago existente");
							}
							else
							{
							if($("#"+nombre+"error").length)
							{
								if ($("#"+nombre+"error").html().indexOf(" medio de pago existente") >= 0)
								{	var str=$("#"+nombre+"error").html().replace(" medio de pago existente","");
									$("#"+nombre+"error").html(str);
								}
							}
							}
						}
					});
		return existe;
				};
				
var existeTipoProducto = function(nombre, codigo){
	var existe=false;
	$.ajax({
						type:'post',
						url:'existetipoproducto.php',
						async:false,
						data:{'nombre' : $("#"+nombre).val() , 'codigo' : codigo },
						success:function(respuesta){
							if(respuesta=='true')
							{	existe = true;
							if(!$("#"+nombre+"error").length)
								$("#"+nombre).after("<span id='"+nombre+"error' class='error'> tipo de producto existente</span>");
							else
								if ($("#"+nombre+"error").html().indexOf(" tipo de producto existente") < 0)
									$("#"+nombre+"error").append(" tipo de producto existente");
							}
							else
							{
							if($("#"+nombre+"error").length)
							{
								if ($("#"+nombre+"error").html().indexOf(" tipo de producto existente") >= 0)
								{	var str=$("#"+nombre+"error").html().replace(" tipo de producto existente","");
									$("#"+nombre+"error").html(str);
								}
							}
							}
						}
					});
		return existe;
				};

var existeProveedor = function(nombre, codigo){
	var existe=false;
	$.ajax({
						type:'post',
						url:'existeproveedor.php',
						async:false,
						data:{'nombre' : $("#"+nombre).val() , 'codigo' : codigo },
						success:function(respuesta){
							if(respuesta=='true')
							{	existe = true;
							if(!$("#"+nombre+"error").length)
								$("#"+nombre).after("<span id='"+nombre+"error' class='error'> proveedor existente</span>");
							else
								if ($("#"+nombre+"error").html().indexOf(" proveedor existente") < 0)
									$("#"+nombre+"error").append(" proveedor existente");
							}
							else
							{
							if($("#"+nombre+"error").length)
							{
								if ($("#"+nombre+"error").html().indexOf("proveedor existente") >= 0)
								{	var str=$("#"+nombre+"error").html().replace(" proveedor existente","");
									$("#"+nombre+"error").html(str);
								}
							}
							}
						}
					});
		return existe;
				};
				
var existeMercaderia = function(nombre,codigo){
	
	var existe=false;
	$.ajax({
						type:'post',
						url:'existeMercaderia.php',
						async:false,
						data:{'nombre' : $("#"+nombre).val() , 'codigo' : codigo },
						success:function(respuesta){
							if(respuesta=='true')
							{	existe = true;
							if(!$("#"+nombre+"error").length)
								$("#"+nombre).after("<span id='"+nombre+"error' class='error'> mercaderia existente</span>");
							else
								if ($("#"+nombre+"error").html().indexOf(" mercaderia existente") < 0)
									$("#"+nombre+"error").append(" mercaderia existente");
							}
							else
							{
							if($("#"+nombre+"error").length)
							{
								if ($("#"+nombre+"error").html().indexOf(" mercaderia existente") >= 0)
								{	var str=$("#"+nombre+"error").html().replace(" mercaderia existente","");
									$("#"+nombre+"error").html(str);
								}
							}
							}
						}
					});
		return existe;
				};