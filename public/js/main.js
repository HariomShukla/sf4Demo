const product = document.getElementById('product');
const category = document.getElementById('category');

if(product)
{
	product.addEventListener('click', e=> {
		// alert(1);
		if(e.target.className == 'btn btn-danger productDelete')
		{
			//alert(2);
			if(confirm("Are You Sure Want To Delete This?"))
			{
				const id = e.target.getAttribute('data-id');
				// alert(id);
				fetch('/product/delete/'+id,{
					method: 'DELETE'
				}).then(res=>window.location.href='/');
			}
		}
	});
}

if(category)
{
	category.addEventListener('click', e=> {
		// alert(1);
		if(e.target.className == 'btn btn-danger categoryDelete')
		{
			//alert(2);
			if(confirm("Are You Sure Want To Delete This?"))
			{
				const id = e.target.getAttribute('data-id');
				// alert(id);
				fetch('/category/delete/'+id,{
					method: 'DELETE'
				}).then(res=>window.location.href='/category');
			}
		}
	});
}