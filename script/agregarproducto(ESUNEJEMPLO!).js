var vector=[];
vector[0]={firstName:"John", lastName:"Doe", age:46};
vector[1]={firstName:"Jhn", lastName:"oe", age:6};
vector[2]={firstName:"Joh", lastName:"Do", age:4};
vector[3]={firstName:"Jon", lastName:"De", age:406};
var index;
for(index=0;index<vector.length;index++){
	alert(vector[index].firstName +' '+ vector[index].lastName+' '+vector[index].age);
}
alert('Empieza la busqueda');
for(index=0;index<vector.length;index++){
	if(vector[index].firstName=='Joh'){
		vector.splice(index, 1);
	}
}
for(index=0;index<vector.length;index++){
	alert(vector[index].firstName +' '+ vector[index].lastName+' '+vector[index].age);
}
vector.push({firstName:"Juan", lastName:"Carlos", age:1500});
alert('aca se hizo el ingreso');
for(index=0;index<vector.length;index++){
	alert(vector[index].firstName +' '+ vector[index].lastName+' '+vector[index].age);
}
var convertido=JSON.stringify(vector);
alert(convertido);