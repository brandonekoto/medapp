(function ($) {
    $.fn.MDE_Autocomplete = function (options) {        
        var defaultOptions = {
            'url' : "/controls/controlajax.php?mod=acte&act=searchacte",
            'attr' : "data-acte_pose",
            element : null,
            module : "home",
            action : "index"
        };
        $('#formProductSale').on('click', '.wrapAutocompleListe .item-suggestion', function (e) {
            e.preventDefault();
            
            return false;
        });
        $('#formLivraison').on('click', '.wrapAutocompleListe .item-suggestion', function (e) {            
            var idActe = $(this).attr(defaultOptions.attr);
            var patient = $(this).attr('data-patient');   
            var idPatient = '.patientInfo';
            var domPatient = $(this).parents('form').find(idPatient);
            $(this).parents('form').find(defaultOptions.element).val(idActe);
            $.ajax({
                'url' : "/controls/controlajax.php",
                'success':function(data){
                    var html =  "";
                    data = eval(data);
                    data = data[0];
                    
                    html += '<div class="col-sm-10" id="patientInfo">\
                    <div class="profile col-lg-3">\
                        <div class="wrapImgProfile">\
                            <img src="/img/personnel/'+ data.filename + "." + data.type+'">\
                        </div>\
                    </div>\
                    <div class="col-lg-9">\
                        <h3 style="margin:0; padding:0; margin-bottom:15px">'+data.nom +' '+ data.postnom +' '+ data.prenom+'</h3>\
                        <table class="table table-striped">\
                            <tbody>\
                                <tr>\
                                    <td>Date de naissance</td>\
                                    <td>'+data.age+'</td>\
                                </tr>\
                                <tr>\
                                    <td>Genre</td>\
                                    <td>'+data.sexe+'</td>\
                                </tr>\
                                <tr>\
                                    <td>Num Fiche interne</td>\
                                    <td>'+data.numinterne+'</td>\
                                </tr>\
                                <tr>\
                                    <td>Num Unique du patient</td>\
                                    <td>'+data.sexe+'</td>\
                                </tr>\
                            </tbody>\
                        </table>\
                    </div>\
                ';
                    domPatient.empty().append(html);
                    $('#idPatientConsult').val(data.idPatient)
                    //$(this).parents('form').find(idPatient).empty().append(html);
                    //idPatient.empty().append(html);
                },
                type : "GET",
                dataType : "json",
                data : {
                    "mod": "patient",
                    act : "getpatient",
                    id : patient
                }
            });
            
            $(this).parents('form').find('.wrapAutocompleListe').remove();
            e.stopPropagation();
            return false;
        });
        
        
        $('#formConsultation').on('click', '.wrapAutocompleListe .item-suggestion', function (e) {            
            var idActe = $(this).attr(defaultOptions.attr);
            var patient = $(this).attr('data-patient');   
            var idPatient = '.patientInfo';
            var domPatient = $(this).parents('form').find(idPatient);
            $(this).parents('form').find(defaultOptions.element).val(idActe);
            $.ajax({
                'url' : "/controls/controlajax.php",
                'success':function(data){
                    var html =  "";
                    data = eval(data);
                    data = data[0];
                    
                    html += '<div class="col-sm-10" id="patientInfo">\
                    <div class="profile col-lg-3">\
                        <div class="wrapImgProfile">\
                            <img src="/img/personnel/'+ data.filename + "." + data.type+'">\
                        </div>\
                    </div>\
                    <div class="col-lg-9">\
                        <h3 style="margin:0; padding:0; margin-bottom:15px">'+data.nom +' '+ data.postnom +' '+ data.prenom+'</h3>\
                        <table class="table table-striped">\
                            <tbody>\
                                <tr>\
                                    <td>Date de naissance</td>\
                                    <td>'+data.age+'</td>\
                                </tr>\
                                <tr>\
                                    <td>Genre</td>\
                                    <td>'+data.sexe+'</td>\
                                </tr>\
                                <tr>\
                                    <td>Fiche interne</td>\
                                    <td>'+data.numinterne+'</td>\
                                </tr>\
                                <tr>\
                                    <td>NU</td>\
                                    <td>'+data.nu+'</td>\
                                </tr>\
                            </tbody>\
                        </table>\
                    </div>\
                ';
                    domPatient.empty().append(html);
                    //$(this).parents('form').find(idPatient).empty().append(html);
                    //idPatient.empty().append(html);
                },
                type : "GET",
                dataType : "json",
                data : {
                    "mod": "patient",
                    act : "getpatient",
                    id : patient
                }
            });
            
            $(this).parents('form').find('.wrapAutocompleListe').remove();
            e.stopPropagation();
            return false;
        });
        
        $('#formInitActe').on('click', '.wrapAutocompleListe .item-suggestion', function (e) {            
            //var idActe = $(this).attr(defaultOptions.attr);
            var patient = $(this).attr('data-patient');   
            var idPatient = '.patientInfo';
            var domPatient = $(this).parents('form').find(".searchpatient");
            var profile = $(this).parents('form').find("#patient");
            $(this).parents('form').find(domPatient).val(patient);
            $.ajax({
                'url' : "/controls/controlajax.php",
                'success':function(data){
                    var html =  "";
                    data = eval(data);
                    data = data[0];
                    
                    html += '<div class="col-sm-10" id="patientInfo">\
                    <div class="profile col-lg-3">\
                        <div class="wrapImgProfile">\
                            <img src="/img/personnel/'+ data.filename + "." + data.type+'">\
                        </div>\
                    </div>\
                    <div class="col-lg-9">\
                        <h3 style="margin:0; padding:0; margin-bottom:15px">'+data.nom +' '+ data.postnom +' '+ data.prenom+'</h3>\
                        <table class="table table-striped">\
                            <tbody>\
                                <tr>\
                                    <td>Date de naissance</td>\
                                    <td>'+data.age+'</td>\
                                </tr>\
                                <tr>\
                                    <td>Genre</td>\
                                    <td>'+data.sexe+'</td>\
                                </tr>\
                                <tr>\
                                    <td>Fiche interne</td>\
                                    <td>'+data.numinterne+'</td>\
                                </tr>\
                                <tr>\
                                    <td>NU</td>\
                                    <td>'+data.nu+'</td>\
                                </tr>\
                            </tbody>\
                        </table>\
                    </div>\
                ';
                    profile.empty().append(html);
                    //$(this).parents('form').find(idPatient).empty().append(html);
                    //idPatient.empty().append(html);
                },
                type : "GET",
                dataType : "json",
                data : {
                    "mod": "patient",
                    act : "getpatient",
                    id : patient
                }
            });
            
            $(this).parents('form').find('.wrapAutocompleListe').remove();
            e.stopPropagation();
            return false;
        });
        $('#formSearchProduct').on('click', '.wrapAutocompleListe .item-suggestion', function (e) {            
            //var idActe = $(this).attr(defaultOptions.attr);
            var product = $(this).attr('data-product');   
            var idPatient = '.productInfo';
            var domPatient = $(this).parents('form').find(".searchproduct");
            var profile = $(this).parents('form').find("#product");
          
            $(this).parents('form').find(domPatient).val(product);
            $.ajax({
                'url' : "/controls/controlajax.php",
                'success':function(data){
                    var html =  "";
                    data = eval(data);
                    data = data[0];
                    
                    html += '<div class="col-sm-12" id="patientInfo">\
                    <div class="profile col-lg-3">\
                        <div class="wrapImgProfile">\
                            <img src="/img/produit/'+ data.filename + "." + data.type+'">\
                        </div>\
                    </div>\
                    <div class="col-lg-9">\
                        <table class="table table-striped">\
                            <tbody>\
                                <tr>\
                                    <td>Désignation</td>\
                                    <td>'+data.lib+'</td><input type="hidden" value="'+data.lib+'"name="designation">\
                                </tr>\
                                <tr>\
                                    <td>Quantité en stock</td>\
                                    <td>'+data.quantite+'</td>\
                                </tr>\
                                <tr>\
                                    <td>Categorie</td>\
                                    <td>'+data.libcategory+'</td>\
                                </tr>\
                                <tr>\
                                    <td>Prix unitaire</td>\
                                    <td>'+data.prixvente+'</td>\
                                </tr>\
                            </tbody>\
                        </table>\
                    </div>\
                ';
                    profile.empty().append(html);
                    //$(this).parents('form').find(idPatient).empty().append(html);
                    //idPatient.empty().append(html);
                },
                type : "GET",
                dataType : "json",
                data : {
                    "mod": "pharmacy",
                    act : "product",
                    id : product
                }
            });
            
            $(this).parents('form').find('.wrapAutocompleListe').remove();
            e.stopPropagation();
            return false;
        });
        
        $('.item-suggestion').on('click', function(evt){
            $(this).parent('.wrapAutocompleListe').hide().remove();
        });
        var selfs = $(this);
        $(this).each(function(i,ele){
            
        });
        defaultOptions = $.extend(defaultOptions, options);
        return $(this).each(function (index,element) {
            $(this).on('keyup', function (evt) {                
                var txt = $(this).val();
                var self = $(this);
                var elementType = self.get()[0].nodeName;
                if(elementType == "INPUT" || elementType == "TEXTAREA"){
                    $.ajax({
                    url: defaultOptions.url,
                    data: {"id":txt,
                            "mod" : defaultOptions.module,
                            "act" :defaultOptions.action,                            
                            },
                    success: function (data) {
                        dataJson = eval(data);                        
                        $('.wrapAutocompleListe').hide(10);
                        var html = '<div class="wrapAutocompleListe"><ul>';
                        for (var item in dataJson) {
                            html += '<li class="item-suggestion" data-patient='+dataJson[item].id_patient+' '+defaultOptions.attr+'=' + dataJson[item].id + '>';
                            html += '<img src="/img/personnel/' + dataJson[item].filename + "." + dataJson[item].type + '">';
                            html += '<div class="item-suggestion-data">' + dataJson[item].nompatient + " " + dataJson[item].prenompatient + '</h5>';
                            html += '<p>Num fiche interne : ' + dataJson[item].numinterne + '</p>';
                            html += '<p>Num unique du patient : ' + dataJson[item].nu + '</p>';
                            html += '<p>Réf Acte : ' + dataJson[item].id + '</p>';
                            html += '<p>Catégorie : ' + dataJson[item].category + '</p>';
                            html += '<p>Acte : ' + dataJson[item].acte_pose + '</p>';
                            html += '</div>';
                            html += '</li>';
                        }
                        html += '</ul>';
                        html += ' </div> ';
                        $(html).insertAfter(self);
                    },
                    type: 'GET',
                    dataType: 'json'
                });
                }else{
                    return false;
                }
                
            });
        });
        
    }
})(jQuery);

