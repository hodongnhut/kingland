
/*For Type Select*/
$(document).on('change','.jProvinceItems .jEle',function(){
	var _ProvinceId = $(this).val(); 
	const _TargetDistrict = $($(this).closest('.jFrmInput').data('target'));  

	_TargetDistrict.find('.jEle').val(0).trigger('change');
 
	if(_ProvinceId!=0){
		var _Data = {ProvinceId:_ProvinceId}; 
		var _Resp = dtl_CallAjax('RockerAjax/NoRequired_GetDistrict',_Data);
		var _ListDistrict = _Resp?.Data?.ListDistrict;  

		if(_ListDistrict){
			let _OptionHtml = '';
			for (var i = 0; i < _ListDistrict.length; i++) {
				let _Items = _ListDistrict[i];
				_OptionHtml += '<option data-lookup="'+_Items.Lookup+'" data-keyword="'+_Items.Keyword+'" ' + 
				(typeof _Items.latlng !== 'undefined' ? 'data-latlng="'+_Items.latlng+'"' : '') + 
				' value="'+_Items.id+'">'+_Items.Name+'</option>';
			}
			 
			if(_TargetDistrict.find('.jEle[is-select2="1"]').length){ 
				_TargetDistrict.find('.jEle.select2-offscreen').empty().append(_OptionHtml); 

				_TargetDistrict.find('.jEle').val(0).trigger('change');
			}else{
				_TargetDistrict.find('.jEle').empty().append(_OptionHtml); 
				_TargetDistrict.find('select.jEle').select2({ placeholder: "Chọn Quận/Huyện", allowClear: true, });
			} 
		}
	}
}).on('change','.jDistrictsItems .jEle',function(){
	var _DistrictId 	= $(this).val(); 
	const _TargetWards 	= $($(this).closest('.jFrmInput').data('target'));  
	const _TargetStreet = $(_TargetWards.data('target'));  

	//_TargetWards.find('.jEle').val(0).trigger('change');
 	_TargetStreet.find('.jEle').val(0).trigger('change');
 
	if(_DistrictId!=0){
		var _Data = {DistrictId:_DistrictId}; 
		var _Resp = dtl_CallAjax('RockerAjax/NoRequired_GetWards',_Data);
		var _ListWards = _Resp?.Data?.ListWards;  
		var _ListStreet = _Resp?.Data?.ListStreet;   

		if(_ListWards){
			let _OptionHtml = '';
			for (var i = 0; i < _ListWards.length; i++) {
				let _Items = _ListWards[i];
				_OptionHtml += '<option data-lookup="'+_Items.Lookup+'" data-keyword="'+_Items.Keyword+'" ' + 
				(typeof _Items.latlng !== 'undefined' ? 'data-latlng="'+_Items.latlng+'"' : '') + 
				' value="'+_Items.id+'">'+_Items.Name+'</option>';
			}
			 
			if(_TargetWards.find('.jEle[is-select2="1"]').length){ 
				_TargetWards.find('.jEle.select2-offscreen').empty().append(_OptionHtml); 

				_TargetWards.find('.jEle').val(0).trigger('change');
			}else{
				_TargetWards.find('.jEle').empty().append(_OptionHtml); 
				_TargetWards.find('select.jEle').select2({ placeholder: "Chọn Phường/Xã", allowClear: true, });
			} 
		}


		if(_ListStreet){
			let _OptionHtml = '';
			for (var i = 0; i < _ListStreet.length; i++) {
				let _Items = _ListStreet[i];
				_OptionHtml += '<option data-lookup="'+_Items.Lookup+'" data-keyword="'+_Items.Keyword+'" ' + 
				(typeof _Items.latlng !== 'undefined' ? 'data-latlng="'+_Items.latlng+'"' : '') + 
				' value="'+_Items.id+'">'+_Items.Name+'</option>';
			}
			 
			if(_TargetStreet.find('.jEle[is-select2="1"]').length){ 
				_TargetStreet.find('.jEle.select2-offscreen').empty().append(_OptionHtml); 

				_TargetStreet.find('.jEle').val(0).trigger('change');
			}else{
				_TargetStreet.find('.jEle').empty().append(_OptionHtml); 
				_TargetStreet.find('select.jEle').select2({ placeholder: "Chọn Phường/Xã", allowClear: true, });
			} 
		} 
	} 

});
/*ed For Type Select*/

/*BG For Type CheckBox*/
$(document).on('change','.jProvinceCB .jEle',function(){
	var _ProvinceId = $(this).val();
	const _TargetDistrict = $($(this).closest('.jFrmInput').data('target'));   
 	_TargetDistrict.find('[type="checkbox"]').prop("checked", false).trigger('change'); 
 	if(_ProvinceId!=0){
 		var _AutoGet = (_TargetDistrict.data('autoget'))?true:false;
		var _Data = {ProvinceId:_ProvinceId,CheckBoxHtml:true,AutoGet:_AutoGet}; 
		var _Html = dtl_GetAniHtml('RockerAjax/NoRequired_GetDistrict',_Data);

 		_TargetDistrict.replaceWith(_Html);  
 	} 
}).on('change','.jDistrictCB [type="checkbox"]',function(){
	var _DistrictId = Frm_GetCheckBoxValue($(this).closest('.jFrmInput')); 
	const _TargetWards = $($(this).closest('.jFrmInput').data('target'));   

	const _TargetStreet = $(_TargetWards.data('target'));  

 	_TargetWards.find('[type="checkbox"]').prop("checked", false).trigger('change'); 
 	
 	_TargetWards.find('.fList').empty();

 	if(_DistrictId!=0){
 		var _AutoGet = (_TargetWards.data('autoget'))?true:false;
		var _Data = {DistrictId:_DistrictId,CheckBoxHtml:true,AutoGet:_AutoGet}; 
		var _Html = dtl_GetAniHtml('RockerAjax/NoRequired_GetWards',_Data);
	 	
	 	const _HtmlWards = _Html?.Wards;
	 	if(_HtmlWards){
	 		_TargetWards.replaceWith(_HtmlWards);

	 	}
	 	const _ListStreet = _Html?.ListStreet;

	 	if(_ListStreet){
			let _OptionHtml = '';
			for (var i = 0; i < _ListStreet.length; i++) {
				let _Items = _ListStreet[i];
	 			_OptionHtml += '<option data-lookup="'+_Items.Lookup+'" data-keyword="'+_Items.Keyword+'" value="'+_Items.id+'">'+_Items.Name+'</option>';
			}
			 
			if(_TargetStreet.find('.jEle[is-select2="1"]').length){ 
				_TargetStreet.find('.jEle.select2-offscreen').empty().append(_OptionHtml); 

				_TargetStreet.find('.jEle').val(0).trigger('change');
			}else{
				_TargetStreet.find('.jEle').empty().append(_OptionHtml); 
				_TargetStreet.find('select.jEle').select2({ placeholder: "Chọn Phường/Xã", allowClear: true, });
			} 
		} 


 	} 
})
/*ED For Type CheckBox*/