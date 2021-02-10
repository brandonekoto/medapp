let lsBaby = [];
$(function () {
    $('body').on('click', "#btn-reset-babies", function (e) {
       e.preventDefault();
       e.stopPropagation();
       lsBaby = [];
       $("#list_baby").empty();
       $(".nb_bb").text(lsBaby.length);
       
    });
    $("body").on('click', "#btn-confirm-babies", function (e) {
        e.preventDefault();
        e.stopPropagation();
        if (lsBaby.length > 0 && $("#acte_accouchement").val().length > 0) {
            $.ajax({
                'url': "/controls/control.php?mod=accouchement&act=addBabies",
                type: 'POST',
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus);
                    if (jqXHR.status == "500") {
                        $.MessageBox(textStatus);
                    } else {
                        $.MessageBox("Une erreur est survenue");
                    }
                },
                success: function (data, textStatus, jqXHR) {
                    location = "/public/accouchement.php?action=view&id=" + $("#acte_accouchement").val(); 
                },
                data: JSON.stringify(
                        {acte: $("#acte_accouchement").val(),
                            babies: lsBaby
                        }
                )

            });
        } else {
            $.MessageBox("Veuillez ajouter d'abord au moins un bébé.");
        }
    });

    $('body').on("click", "#btn-add-baby", function (e) {

        let err = [];
        let etat_bb = $("#etat").val();
        let nom = $("#nom").val();
        let postnom = $("#postnom").val();
        let prenom = $("#prenom").val();
        let dateNaiss = $("#datenaiss").val();
        let sexe = $("#sexe").find("option:selected").val();
        let poids = $("#poids").val();
        let taille = $("#taille").val();
        let apgar = $("#apgar").val();
        let g_sang = $("#group_sang").find("option:selected").val();
        let pc = $("#pc").val();
        let mode = $("#mode").find('option:selected').val();
        let heureAcc = $("#heureAccouchement").val();
        let dureAcc = $("#dureAccouchement").val();
        let gestite = $("#gestite").val();
        let parite = $("#parite").val();
        let avortSpon = $("#avortSpon").val();
        let diabete = $("#diabete").val();
        let glycemie = $("#glycemie").val();
        let hta = $("#hta").find("option:selected").val();
        let ta = $("#ta").val();
        let hiv = $("#hiv").val();
        let ivg = $("#ivg").val();
        let tbc = $("#tbc").val();
        let tp = $("#tp").val();
        let ddr = $("#ddr").val();
        let cpn = $("#cpn").val();
        let la = $("#la").val();
        let urogen = $("#urogen").val();
        let echo = $("#echo").val();
        let rpm = $("#rpm").val();
        let teint = $("#teint").val();
        let t = $("#tt").val();
        let conjonctives = $("#conjonctives").val();
        let fc = $("#fc").val();
        let fr = $("#fr").val();
        let abdomen = $("#abdomen").val();
        let ogf = $("#ogf").val();
        let autres = $("#autres").val();
        let vigilance = $("#vigilance").val();
        let motilite = $("#motilite").val();
        let eri = $("#eri").val();
        let tonus_passif = $("#tonus_passif").val();
        let tonus_actif = $("#tonus_passif").val();
        let succion = $("#succion").val();
        let grasping = $("#grasping").val();
        let moro = $("#moro").val();
        let extension_croisee = $("#extension_croisee").val();
        let galand_incurvation = $("#galand_incurvation").val();
        if (!nom || nom.length == 0) {
            err.push("Veuillez saisir le nom du bebe");
            $.MessageBox("Veuillez saisir le nom du bebe");
        }
        if (!postnom || postnom.length == 0) {
            err.push("Veuillez saisir le postnom du bebe");
            $.MessageBox("Veuillez saisir le postnom du bebe");
        }
        if (!prenom || prenom.length == 0) {
            err.push("Veuillez saisir le prenom du bebe");
            $.MessageBox("Veuillez saisir le prenom du bebe");
        }
        if (!taille || taille.length == 0) {
            err.push("Veuillez saisir la taille du bébé");
            $.MessageBox("Veuillez saisir la taille du bébé");
        }
        if (!poids || poids.length == 0) {
            err.push("Veuillez saisir le poids du bebe");
            $.MessageBox("Veuillez saisir le poids du bebe");
        }
        if (!sexe || sexe.length == 0) {
            err.push("Veuillez sélectionner le sexe du bebe");
            $.MessageBox("Veuillez sélectionner le sexe du bebe");
        }
        if (!dureAcc || dureAcc.length == 0) {
            err.push("Veuillez saisir la durée de l'accouchement du bebe");
            $.MessageBox("Veuillez saisir la durée de l'accouchement du bebe");
        }
        if (!heureAcc || heureAcc.length == 0) {
            err.push("Veuillez saisir l'heure de l'accouchement du bebe");
            $.MessageBox("Veuillez saisir l'heure de l'accouchement du bebe");
        }

        if (!apgar || apgar.length == 0) {
            err.push("Veuillez saisir l'apgar du bebe");
            $.MessageBox("Veuillez saisir l'apgar  du bebe");
        }
        if (!pc || pc.length == 0) {
            err.push("Veuillez saisir le pc du bebe");
            $.MessageBox("Veuillez saisir le pc du bebe");
        }
        if (!gestite || gestite.length == 0) {
            err.push("Veuillez saisir la gestite du bebe");
            $.MessageBox("Veuillez saisir la gestite du bebe");
        }
        if (!parite || parite.length == 0) {
            err.push("Veuillez saisir la parité du bebe");
            $.MessageBox("Veuillez saisir la parité du bebe");
        }
        if (!diabete || diabete.length == 0) {
            err.push("Veuillez saisir la diabete du bebe");
            $.MessageBox("Veuillez saisir la diabete du bebe");
        }
        if (!glycemie || glycemie.length == 0) {
            err.push("Veuillez saisir la glycemie du bebe");
            $.MessageBox("Veuillez saisir la glycémie du bebe");
        }
        if (!hta || hta.length == 0) {
            err.push("Veuillez saisir le HTA du bebe");
            $.MessageBox("Veuillez saisir le HTA du bebe");
        }
        if (!ta || ta.length == 0) {
            err.push("Veuillez saisir le TA du bebe");
            $.MessageBox("Veuillez saisir le TA du bebe");
        }
        if (!hiv || hiv.length == 0) {
            err.push("Veuillez saisir le HIV du bebe");
            $.MessageBox("Veuillez saisir le HIV du bebe");
        }
        if (!tbc || tbc.length == 0) {
            err.push("Veuillez saisir le tbc du bebe");
            $.MessageBox("Veuillez saisir le tbc du bebe");
        }
        if (!ddr || ddr.length == 0) {
            err.push("Veuillez saisir le DDR du bebe");
            $.MessageBox("Veuillez saisir le DDR du bebe");
        }
        if (!cpn || cpn.length == 0) {
            err.push("Veuillez saisir le CPN du bebe");
            $.MessageBox("Veuillez saisir le CPN du bebe");
        }
        if (!urogen || urogen.length == 0) {
            err.push("Veuillez saisir l'urogen du bebe");
            $.MessageBox("Veuillez saisir l'urogen du bebe");
        }
        if (!echo || echo.length == 0) {
            err.push("Veuillez saisir l'écho du bebe");
            $.MessageBox("Veuillez saisir l'écho du bebe");
        }
        if (!la || la.length == 0) {
            err.push("Veuillez saisir le LA du bebe");
            $.MessageBox("Veuillez saisir le LA du bebe");
        }
        if (!rpm || rpm.length == 0) {
            err.push("Veuillez saisir le RPM du bebe");
            $.MessageBox("Veuillez saisir le RPM du bebe");
        }

        if (!teint || teint.length == 0) {
            err.push("Veuillez saisir le teint du bebe");
            $.MessageBox("Veuillez saisir le teint du bebe");
        }
        if (!t || t.length == 0) {
            err.push("Veuillez saisir le T du bebe");
            $.MessageBox("Veuillez saisir le T du bebe");
        }
        if (!conjonctives || conjonctives.length == 0) {
            err.push("Veuillez saisir les conjonctives du bebe");
            $.MessageBox("Veuillez saisir les conjonctives du bebe");
        }
        if (!fc || fc.length == 0) {
            err.push("Veuillez saisir le FC du bebe");
            $.MessageBox("Veuillez saisir le FC du bebe");
        }
        if (!fr || fr.length == 0) {
            err.push("Veuillez saisir le FR du bebe");
            $.MessageBox("Veuillez saisir le FR du bebe");
        }
        if (!abdomen || abdomen.length == 0) {
            err.push("Veuillez saisir l'abdomen du bebe");
            $.MessageBox("Veuillez saisir l'abdomen du bebe");
        }
        if (!ogf || ogf.length == 0) {
            err.push("Veuillez saisir le OGF du bebe");
            $.MessageBox("Veuillez saisir le OGF du bebe");
        }
        if (!autres || autres.length == 0) {
            err.push("Veuillez saisir autres du bebe");
            $.MessageBox("Veuillez saisir autres du bebe");
        }
        if (!vigilance || vigilance.length == 0) {
            err.push("Veuillez saisir la vigilance du bebe");
            $.MessageBox("Veuillez saisir la vigilance du bebe");
        }
        if (!motilite || motilite.length == 0) {
            err.push("Veuillez saisir la motilité du bebe");
            $.MessageBox("Veuillez saisir la motilité du bebe");
        }
        if (!eri || eri.length == 0) {
            err.push("Veuillez saisir l'ERI du bebe");
            $.MessageBox("Veuillez saisir l'ERI du bebe");
        }
        if (!tonus_passif || tonus_passif.length == 0) {
            err.push("Veuillez saisir le tonus passif du bebe");
            $.MessageBox("Veuillez saisir le tonus actif du bebe");
        }
        if (!tonus_actif || tonus_actif.length == 0) {
            err.push("Veuillez saisir le tonus actif du bebe");
            $.MessageBox("Veuillez saisir le tonus actif du bebe");
        }
        if (!succion || succion.length == 0) {
            err.push("Veuillez saisir la succion déglutition du bebe");
            $.MessageBox("Veuillez saisir la  succion déglutition du bebe");
        }
        if (!grasping || grasping.length == 0) {
            err.push("Veuillez saisir le grasping du bebe");
            $.MessageBox("Veuillez saisir le grasping du bebe");
        }
        if (!moro || moro.length == 0) {
            err.push("Veuillez saisir le moro du bebe");
            $.MessageBox("Veuillez saisir le moro du bebe");
        }
        if (!extension_croisee || extension_croisee.length == 0) {
            err.push("Veuillez saisir l'extension croisée du bebe");
            $.MessageBox("Veuillez saisir l'extension croisée du bebe");
        }
        if (!galand_incurvation || galand_incurvation.length == 0) {
            err.push("Veuillez saisir le galand incurvation du bebe");
            $.MessageBox("Veuillez saisir le galand incurvation du bebe");
        }
        if (err.length > 0) {
            $.MessageBox("Veuillez corriger les champs ayant des erreurs");
        } else {

            let badyObj = new Object();
            badyObj.nom = nom;
            badyObj.postnom = postnom;
            badyObj.prenom = prenom;
            badyObj.statut = etat_bb;
            badyObj.dateNaiss = dateNaiss;
            badyObj.sexe = sexe;
            badyObj.poids = poids;
            badyObj.taille = taille;
            badyObj.apgar = apgar;
            badyObj.pc = pc;
            badyObj.groupe_sang = g_sang;
            badyObj.mode = mode;
            badyObj.heureAccouchement = heureAcc;
            badyObj.dureAccouchement = dureAcc;
            badyObj.gestite = gestite;
            badyObj.parite = parite;
            badyObj.diabete = diabete;
            badyObj.glycemie = glycemie;
            badyObj.hta = hta;
            badyObj.ta = ta;
            badyObj.hiv = hiv;
            badyObj.ivg = ivg;
            badyObj.tbc = tbc;
            badyObj.tp = tp;
            badyObj.t = t;
            badyObj.ddr = ddr;
            badyObj.cpn = cpn;
            badyObj.la = la;
            badyObj.urogen = urogen;
            badyObj.echo = echo;
            badyObj.rpm = rpm;
            badyObj.teint = teint;
            badyObj.conjonctives = conjonctives;
            badyObj.fc = fc;
            badyObj.fr = fr;
            badyObj.abdomen = abdomen;
            badyObj.ogf = ogf;
            badyObj.autres = autres;
            badyObj.vigilance = vigilance;
            badyObj.motilite = motilite;
            badyObj.eri = eri;
            badyObj.tonus_passif = tonus_passif;
            badyObj.tonus_actif = tonus_actif;
            badyObj.succion = succion;
            badyObj.grasping = grasping;
            badyObj.moro = moro;
            badyObj.extension_croisee = extension_croisee;
            badyObj.galand_incurvation = galand_incurvation;

            let html = `
<div class="row">
                                                                                    <div class="col-md-7">
                                                                                        <div class=" personne-info">
                                                                                            <div class="line-personne-info"><span class="champ">Statut :</span><span class="val-line-personne-info v_statut">${etat_bb}</span></div> 
                                                                                            <div class="line-personne-info"><span class="champ">Nom :</span><span class="val-line-personne-info " id="nom_v">${nom}</span></div> 
                                                                                            <div class="line-personne-info"><span class="champ">Prénom :</span><span class="val-line-personne-info" id="prenom_v">${prenom}</span></div> 
                                                                                            <div class="line-personne-info"><span class="champ">Post-nom :</span><span class="val-line-personne-info" id="postnom_v">${postnom}</span></div> 
                                                                                            <div class="line-personne-info"><span class="champ">Groupe Sanguin :</span><span class="val-line-personne-info" id="groupe_sang_v">${g_sang}</span></div>                                                                                            
                                                                                            <div class="line-personne-info"><span class="champ">Sexe :</span><span class="val-line-personne-info" id="sexe_v">${sexe }</span></div> 
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-5">
                                                                                        <div class="wrapImgProfile">
                                                                                            <img src="/img/personnel/avatar.jpg" id="img_v">
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                                <hr>
                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label for="text1" class="control-label col-lg-12">Corpulences </label>
                                                                                        </div>
                                                                                        <hr>
                                                                                        <div class="grid-data">
                                                                                            <div class="item-grid-data" style="">
                                                                                                <span class="item-grid-data-icone">Taille</span>
                                                                                                <span class="item-grid-data-val" id="taille_v">${taille}</span>
                                                                                                <span>cm</span>
                                                                                            </div>
                                                                                            <div class="item-grid-data"style="" >
                                                                                                <span class="item-grid-data-icone">Poids</span>
                                                                                                <span class="item-grid-data-val" id="poids_v">${poids}</span>
                                                                                                <span>Kg</span>
                                                                                            </div>
                                                                                            <div class="item-grid-data" style="">
                                                                                                <span class="item-grid-data-icone">PC</span>
                                                                                                <span class="item-grid-data-val" id="pc">${pc}</span>
                                                                                                <span>C°</span>
                                                                                            </div>
                                                                                            <div class="item-grid-data" style="">
                                                                                                <span class="item-grid-data-icone">APGAR</span>
                                                                                                <span class="item-grid-data-val" id="apgar_v">${apgar}</span>
                                                                                                <span>&nbsp;</span>
                                                                                            </div>


                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label for="text1" class="control-label col-lg-12">Accouchement </label>
                                                                                        </div>
                                                                                        <div class="col-md-12">
                                                                                            <div class=" personne-info">
                                                                                                <div class="line-personne-info"><span class="champ">Mode :</span><span class="val-line-personne-info" id="mode_v"> ${etat_bb == 1 ? "En vie" : "Décédé"}</span></div> 
                                                                                                <div class="line-personne-info"><span class="champ">Heure  :</span><span class="val-line-personne-info" id="heure_v">${heureAcc}</span></div> 
                                                                                                <div class="line-personne-info"><span class="champ">Durée :</span><span class="val-line-personne-info" id="duree_v">${dureAcc}</span></div> 
                                                                                                <div class="line-personne-info"><span class="champ">Avortement Spontané :</span><span class="val-line-personne-info" id="avortSpon_v">${avortSpon}</span></div> 

                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label for="text1" class="control-label col-lg-12">Renseignements maternels </label>
                                                                                        </div>
                                                                                        <div class="col-md-12">
                                                                                            <div class=" personne-info">
                                                                                                <div class="line-personne-info"><span class="champ">Gestité/Parité :</span><span class="val-line-personne-info" id="gestite_v">${gestite + "|" + parite}</span></div> 
                                                                                                <div class="line-personne-info"><span class="champ">Avortement spont.  :</span><span class="val-line-personne-info" id="avortement_spont_v"></span></div> 
                                                                                                <div class="line-personne-info"><span class="champ">IVG :</span><span class="val-line-personne-info" id="ivg_v">${ivg}</span></div> 
                                                                                                <div class="line-personne-info"><span class="champ">GS :</span><span class="val-line-personne-info" id="gs_v"></span></div> 
                                                                                                <div class="line-personne-info"><span class="champ">Diabete/Glycemie :</span><span class="val-line-personne-info" id="diabete_v">${diabete + " | " + glycemie}</span></div> 
                                                                                                <div class="line-personne-info"><span class="champ">HTA/Dernière Ta :</span><span class="val-line-personne-info" id="hta_v">${hta}</span></div> 
                                                                                                <div class="line-personne-info"><span class="champ">Test HIV :</span><span class="val-line-personne-info" id="hiv_v">${hiv}</span></div>
                                                                                                <div class="line-personne-info"><span class="champ">TPC :</span><span class="val-line-personne-info" id="tbc_v">${tbc}</span></div> 
                                                                                                <div class="line-personne-info"><span class="champ">DDR :</span><span class="val-line-personne-info" id="ddr_v">${ddr}</span></div>
                                                                                                <div class="line-personne-info"><span class="champ">TP :</span><span class="val-line-personne-info" id="tp_v">${tp}</span></div> 
                                                                                                <div class="line-personne-info"><span class="champ">CPN :</span><span class="val-line-personne-info" id="cpn_v">${cpn}</span></div>
                                                                                                <div class="line-personne-info"><span class="champ">Echo :</span><span class="val-line-personne-info" id="echo_v">${echo}</span></div> 
                                                                                                <div class="line-personne-info"><span class="champ">RPM :</span><span class="val-line-personne-info" id="rpm_v">${rpm}</span></div> 
                                                                                                <div class="line-personne-info"><span class="champ">LA :</span><span class="val-line-personne-info" id="la_v">${la}</span></div> 
                                                                                                
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
            
                                                                                    
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label for="text1" class="control-label col-lg-12"> Examen Morphologique </label>
                                                                                        </div>
                                                                                        <div class="col-md-12">
                                                                                            <div class=" personne-info">
                                                                                                <div class="line-personne-info"><span class="champ">Teint/T :</span><span class="val-line-personne-info" id="teint_v">${teint + " | " + t}</span></div> 
                                                                                                <div class="line-personne-info"><span class="champ">Conjonctives  :</span><span class="val-line-personne-info" id="conjonctives_v">${conjonctives}</span></div> 
                                                                                                <div class="line-personne-info"><span class="champ">Thorax (Coeur (FC) & Poumons(FR)) :</span><span class="val-line-personne-info" id="thorax_v">${fc + " | " + fr}</span></div> 
                                                                                                <div class="line-personne-info"><span class="champ">Abdomen :</span><span class="val-line-personne-info" id="abdomen_v">${abdomen}</span></div>                                                                                                 
                                                                                                <div class="line-personne-info"><span class="champ">Organes Génitaux externes :</span><span class="val-line-personne-info" id="ogf_v">${ogf}</span></div> 
                                                                                                <div class="line-personne-info"><span class="champ">Autres :</span><span class="val-line-personne-info" id="autres_v">${autres}</span></div>                                                                                                
                                                                                                
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label for="text1" class="control-label col-lg-12"> Examen Neurologique </label>
                                                                                        </div>
                                                                                        <div class="col-md-12">
                                                                                            <div class=" personne-info">
                                                                                                <div class="line-personne-info"><span class="champ">Vigilance :</span><span class="val-line-personne-info" id="vigilance_v">${vigilance}</span></div> 
                                                                                                <div class="line-personne-info"><span class="champ">Motilité spontanée et réactive  :</span><span class="val-line-personne-info" id="motilite_v">${motilite}</span></div> 
                                                                                                <div class="line-personne-info"><span class="champ">Eric :</span><span class="val-line-personne-info" id="eri_v">${eri}</span></div> 
                                                                                                <div class="line-personne-info"><span class="champ">Tonus passif :</span><span class="val-line-personne-info" id="tonus_passif_v">${tonus_passif}</span></div> 
                                                                                                <div class="line-personne-info"><span class="champ">Tonus actif :</span><span class="val-line-personne-info" id="tonus_actif_v">${tonus_actif}</span></div> 
                                                                                                <div class="line-personne-info"><span class="champ">Succion déglutition :</span><span class="val-line-personne-info" id="succion_v">${succion}</span></div> 
                                                                                                <div class="line-personne-info"><span class="champ">Grasping :</span><span class="val-line-personne-info" id="grasping_v">${grasping}</span></div>
                                                                                                <div class="line-personne-info"><span class="champ">Moro :</span><span class="val-line-personne-info" id="moro_v">${moro}</span></div>
                                                                                                <div class="line-personne-info"><span class="champ">Extension croisée :</span><span class="val-line-personne-info" id="extension_croisee_v">${extension_croisee}</span></div>
                                                                                                <div class="line-personne-info"><span class="champ">Galand incurvation :</span><span class="val-line-personne-info" id="galand_incurvation_v">${galand_incurvation}</span></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    
                                                                                    
                                                                                </div>
`;

            let html$ = $(html).wrap("<div class='bady'></div>").appendTo("#list_baby");
            lsBaby.push(badyObj);

            $("#etat").val("");
            $("#nom").val("");
            $("#postnom").val("");
            $("#prenom").val("");
            $("#datenaiss").val("");
            $("#sexe").find("option:selected").val("");
            $("#poids").val("");
            $("#taille").val("");
            $("#apgar").val("");
            $("#group_sang").find("option:selected").val("");
            $("#pc").val("");
            $("#mode").find('option:selected').val("");
            $("#heureAccouchement").val("");
            $("#dureAccouchement").val("");
            $("#gestite").val("");
            $("#parite").val("");
            $("#avortSpon").val("");
            $("#diabete").val("");
            $("#glycemie").val("");
            $("#hta").find("option:selected").val("");
            $("#ta").val("");
            $("#hiv").val("");
            $("#ivg").val("");
            $("#tbc").val("");
            $("#tp").val("");
            $("#ddr").val("");
            $("#cpn").val("");
            $("#la").val("");
            $("#urogen").val("");
            $("#echo").val("");
            $("#rpm").val("");
            $("#teint").val("");
            $("#tt").val("");
            $("#conjonctives").val("");
            $("#fc").val("");
            $("#fr").val("");
            $("#abdomen").val("");
            $("#ogf").val("");
            $("#autres").val("");
            $("#vigilance").val("");
            $("#motilite").val("");
            $("#eri").val("");
            $("#tonus_passif").val("");
            $("#tonus_passif").val("");
            $("#succion").val("");
            $("#grasping").val("");
            $("#moro").val("");
            $("#extension_croisee").val("");
            $("#galand_incurvation").val("");
            $(".nb_bb").text(lsBaby.length);
            /*
             let    nom_ = $("#nom_v");
             let postnom_ = $("#postnom_v");
             let prenom_ = $("#prenom_v");
             let sexe_ = $("#sexe_");
             let poids_ = $("#poids_v");
             let taille_ = $("#taille_v");
             let apgar_ = $("#apgar_v");
             let g_sang_ = $("#group_sang_v");
             let pc_ = $("#pc_v");
             let mode_ = $("#mode_v");
             let heureAcc_ = $("#heure_v");
             let dureAcc_ = $("#dure_v");
             let gestite_ = $("#gestite_v");
             let parite_ = $("#parite_v");
             let avortSpon_ = $("#avortSpon_v");
             let diabete_ = $("#diabete_v");
             let glycemie_ = $("#glycemie_v");
             let hta_ = $("#hta_v");
             let ta_ = $("#ta_v");
             let hiv_ = $("#hiv_v");
             let ivg_ = $("ivg_v");
             let tbc_ = $("#tbc_v");
             let tp_ = $("#tp_v");
             let ddr_ = $("#ddr_v");
             let cpn_ = $("#cpn_v");
             let la_ = $("#la_v");
             let urogen_ = $("#urogen_v");
             let echo_ = $("#echo_v");
             let rpm_ = $("#rpm_v");
             let teint_ = $("#teint_v");
             let t_ = $("#t_v");
             let conjonctives_ = $("#conjonctives_v");
             let fc_ = $("#fc_v");
             let fr_ = $("#fr_v");
             let abdomen_ = $("#abdomen_v");
             let ogf_ = $("#ofg_v");
             let autres_ = $("autres_v");
             let vigilance_ = $("vigilance_v");
             let motilite_ = $("#motilite_v");
             let eri_ = $("#eri_v");
             let tonus_passif_ = $("#tonus_passif_v");
             let tonus_actif_ = $("#tonus_passif_v");
             let succion_ = $("#succion_v");
             let grasping_ = $("#gasping_v");
             let moro_ = $("#moro_v");
             let extension_croisee_ = $("#extension_croisee_v");
             let galand_incurvation_ = $("#galand_incurvation_v");*/
        }
    });


    $("body").on("change", '.selectdestination', function (e) {
        e.preventDefault();
        e.stopPropagation();

        if ($(this).val() == "1") {
            $('.searchpatientforlivraison').show();
            $('.showselectedpatientforlivraison').show();
        } else {
            $('.searchpatientforlivraison').hide();
            $('.showselectedpatientforlivraison').hide();
        }

    });


    var listExamen = $('#listExamen'), formDiagnostic = $('#formDiagnostic');
    refCat = $('.refCat'),
            selectPatientForActe = $('#selectPatientForActe'), patientInfo = $('#patientInfo'), selectPatientImg = $('#selectPatientImg');

    listExamen.on('change', function (evt) {

    });
    var btnAddExam = $('#btn-add-examen');
    $('#btn-add-examen').on('click', function (evt) {
        var ref = $(this).parents('#formDiagnostic').find('.refCat').val();
        if (!ref) {
            alert("Acte ne peut être vide veuillez selectionner un acte d'abord");
        } else {
            var selectedExamen = $(this).parents('.input-group').find('#listExamen').get()[0].selectedIndex;
            var examen = $(this).parents('.input-group').find('#listExamen option').get(selectedExamen);
            examen = $(examen);
            idExamen = examen.attr('data-id');
            //console.log(.get(), indexExamenSelect);
        }
        //evt.preventDefault();
        return false;
    });


    selectPatientForActe.on('change', function (evt) {
        var self = $(this);
        var idPatient = $(this).val();
        $.get('http://mde.rubis.cd/controls/control.php?mod=patient&act=get&id=' + idPatient, function (data) {
            patiantData = JSON.parse(data)[0];
        });
        return false;
    });
    $('.wrapAutocompleListe').hide(100);
    $('body ').on('click', '.wrapAutocompleListe .item-suggestion', function (e) {
        //var idActe = $(this).attr('data-acte_pose');
        //$(this).parents('form').find(".refCat").val(idActe);        
        //$(this).parents('.wrapAutocompleListe').hide().empty();
    });
    $('body ').on('click', function (e) {
        $('.wrapAutocompleListe').hide();
    });

    /*$('.refCat').on('keyup', function(evt){
     
     var txt = $(this).val();
     var self = $(this);
     $.ajax({
     url : '/controls/controlajax.php?mod=acte&act=searchacte&id=' + txt,
     success :function(data){
     dataJson = eval(data);
     $('.wrapAutocompleListe').hide(10);
     var html  = '<div class="wrapAutocompleListe"><ul>';                   
     for (var item in dataJson) {
     html += '<li class="item-suggestion" data-acte_pose='+dataJson[item].id+'>';                                                 
     html +=          '<img src="/img/personnel/'+dataJson[item].filename + "."+dataJson[item].type+'">';
     html+=                    '<div class="item-suggestion-data">'+dataJson[item].nompatient + " " +dataJson[item].prenompatient+'</h5>';
     html+=                        '<p>Réf Acte : '+ dataJson[item].id+'</p>';
     html+=                        '<p>Catégorie : '+ dataJson[item].category+'</p>';
     html+=                        '<p>Acte : '+ dataJson[item].acte_pose+'</p>';
     html+=                    '</div>'   ;                                                                                      
     html+=               '</li>';
     }
     html+='</ul>';
     html +=       ' </div> ';
     $(html).insertAfter(self);                    
     },
     type : 'GET',
     dataType : 'json'
     });
     });
     */
    $('.item-suggestion').on('click', function (evt) {
        //$(this).parent('.wrapAutocompleListe').hide().remove();
    });

    $('.refCat').MDE_Autocomplete(
            {
                url: "/controls/controlajax.php?",
                module: "acte",
                action: "searchacte",
                element: ".refCat"
            }
    );

    $('.refCat').MDE_Autocomplete(
            {
                url: "/controls/controlajax.php?",
                module: "accouchement",
                action: "searchacte",
                element: ".refCat"
            }
    );

    /*$('.refDiagnostic').MDE_Autocomplete(
     {
     url : "/controls/controlajax.php?",
     module : "acte",
     action : "searchacte",
     element : ".refDiagnostic"
     }
     );
     $('#refDiagnostic').MDE_Autocomplete({
     url : "/controls/controlajax.php?",
     module : "acte",
     action : "getdiagnosticbydate"
     }
     );*/

    $('.searchform').submit(function (e) {
        e.preventDefault();
        return false;
    });
    $('.input-search-patient').on('keyup', function (e) {
        e.preventDefault();
        var $this = $(this);
        var q = $($this).val();

        $.ajax({
            url: $this.parents('.searchform').attr('action'),
            type: "GET",
            success: function (data) {
                data = eval(data);

                var html = "";
                if (data.length > 0) {
                    $this.parents('.box').find('.body .table tbody').empty();
                    $this.parents('.box').find('.body .alert').remove();
                    var count = 0;
                    for (var item  in data) {
                        count++;
                        let typp = "ordinaire";
                        if (data[item].typePatient == 0) {
                            typp = "ordinaire";
                        } else if (data[item].typePatient == 1) {
                            typp = "Externe";
                        } else {
                            typp = "Interne";
                        }
                        if (data[item].raisonsociale) {
                            html += '<tr >\
                                <td>' + count + '</td>\
                                <td>\
                                    <a href="/controls/control.php?mod=patient&amp;act=view&amp;id=' + data[item].idPatient + '">\
                                        <img src="/img/personnel/' + data[item].filename + '.' + data[item].type + '" class="user-profile">\
                                        <h5>' + data[item].nom + " " + data[item].prenom + '</h5></a>\
                                </td>\
                                <td>' + ((data[item].nu) ? data[item].nu : "") + '</td>\
                                <td>' + data[item].numinterne + '</td>\
                                <td>' + data[item].raisonsociale + '</td>\
                                <td>' + typp + '</td>\
                                <td>' + data[item].sexe + '</td>\
                            <td>' + ((data[item].statut == 0) ? "En vie" : "décédé") + '</td>\
                                <td>' + data[item].dateEnregistrement + '</td>\
                                <td>\
                                    <a href="/public/actes_medicaux.php?action=view&amp;id=' + data[item].idPatient + '"><span class="glyphicon glyphicon-eye-open"></span></a>\
                                    <a href="/public/print.php?id=' + data[item].id + '" class="text-success printbtn"><i class="glyphicon glyphicon-print"></i></a>\
                                    <a href="" class="danger text-danger"><span class="glyphicon glyphicon-remove"></span></a></td>\
                            </tr>';
                        } else {
                            html += '<tr >\
                                <td>' + count + '</td>\
                                <td>\
                                    <a href="/controls/control.php?mod=patient&amp;act=view&amp;id=' + data[item].idPatient + '">\
                                        <img src="/img/personnel/' + data[item].filename + '.' + data[item].type + '" class="user-profile">\
                                        <h5>' + data[item].nom + " " + data[item].prenom + '</h5></a>\
                                </td>\
                                <td>' + ((data[item].nu) ? data[item].nu : "") + '</td>\
                                  <td>' + data[item].numinterne + '</td>\
                                <td>Privé</td>\
                                <td>' + typp + '</td>\
                                <td>' + data[item].sexe + '</td>\
                            <td>' + ((data[item].statut == 0) ? "En vie" : "décédé") + '</td>\
                                <td>' + data[item].dateEnregistrement + '</td>\
                                <td>\
                                    <a href="/public/actes_medicaux.php?action=view&amp;id=' + data[item].idPatient + '"><span class="glyphicon glyphicon-eye-open"></span></a>\
                                    <a href="/public/print.php?id=' + data[item].idPatient + '" class="text-success printbtn"><i class="glyphicon glyphicon-print"></i></a>\
                                    <a href="" class="danger text-danger"><span class="glyphicon glyphicon-remove"></span></a></td>\
                            </tr>';
                        }

                    }
                    $this.parents('.box').find('.body .table tbody').append(html);
                } else {
                    $this.parents('.box').find('.body .alert').remove();
                    $this.parents('.box').find('.body .table tbody').empty().parent().parent().append("<div class='alert alert-info'>Aucune information trouvée</div>");
                }

            },
            dataType: "json",
            data: {
                'q': q
            }
        }

        );
    });

    $('.input-search').on('keyup', function (e) {
        e.preventDefault();
        var $this = $(this);
        var q = $(this).val();
        $.ajax({
            url: $this.parents('.searchform').attr('action'),
            type: "GET",
            success: function (data) {
                data = eval(data);

                var html = "";
                if (data.length > 0) {
                    $this.parents('.box').find('.body .table tbody').empty();
                    $this.parents('.box').find('.body .alert').remove();
                    var count = 0;
                    for (var item  in data) {
                        count++;
                        html += '<tr >\
                                <td>' + count + '</td>\
                                <td>' + data[item].id + '</td>\
                                <td>\
                                    <a href="/controls/control.php?mod=patient&amp;act=view&amp;id=' + data[item].id + '">\
                                        <img src="/img/personnel/' + data[item].filename + '.' + data[item].type + '" class="user-profile">\
                                        <h5>' + data[item].nompatient + " " + data[item].prenompatient + '</h5></a>\
                                </td>\
                                <td>' + data[item].nomagent + " " + data[item].prenomagent + "<br>(" + data[item].fonctionagent + '</td>\
                                <td>' + data[item].acte_pose + '</td>\
                                <td>' + data[item].category + '</td>\
                                <td>' + data[item].date + '</td>\
                                <td>\
                                    <a href="/public/actes_medicaux.php?action=view&amp;id=' + data[item].id + '"><span class="glyphicon glyphicon-eye-open"></span></a>\
                                    <a href="/public/print.php?id=' + data[item].id + '" class="text-success printbtn"><i class="glyphicon glyphicon-print"></i></a>\
                                    <a href="" class="danger text-danger"><span class="glyphicon glyphicon-remove"></span></a></td>\
                            </tr>';

                    }
                    $this.parents('.box').find('.body .table tbody').append(html);
                } else {
                    $this.parents('.box').find('.body .alert').remove();
                    $this.parents('.box').find('.body .table tbody').empty().parent().parent().append("<div class='alert alert-info'>Aucune information trouvée</div>");
                }

            },
            dataType: "json",
            data: {
                'q': q
            }
        }

        );
    });

    $('.searchpatient').on('keyup', function (e) {
        e.preventDefault();
        var $this = $(this);
        var q = $(this).val();
        $.ajax({
            url: "/controls/control.php",
            type: "GET",
            data: {

                mod: "patient",
                act: "searchpatient",
                patient: q
            },
            dataType: "json",
            success: function (data) {
                dataJson = eval(data);
                $('.wrapAutocompleListe').hide(10);
                var html = '<div class="wrapAutocompleListe" style=" margin-top : 0px"><ul>';
                for (var item in dataJson) {
                    html += '<li class="item-suggestion" data-patient=' + dataJson[item].idPatient + '>';
                    html += '<img src="/img/personnel/' + dataJson[item].filename + "." + dataJson[item].type + '">';
                    html += '<div class="item-suggestion-data">' + dataJson[item].nom + " " + dataJson[item].prenom + '</h5>';
                    html += '<p>Date de naissance : ' + dataJson[item].age + '</p>';
                    html += '<p>Sexe : ' + dataJson[item].sexe + '</p>';
                    html += '<p>Type : ' + (dataJson[item].typePatient == 0 ? "Ordinaire" : "Affilié") + '</p>';
                    html += '<p>Fiche interne : ' + dataJson[item].numinterne + '</p>';
                    html += '</div>';
                    html += '</li>';
                }
                html += '</ul>';
                html += ' </div> ';
                $(html).insertAfter($this);
            }
        });
    });


    $('.input-acte-price').on('keyup', function (e) {
        e.preventDefault();
        var $this = $(this);
        var q = $(this).val();
        $.ajax({
            url: "/controls/control.php",
            type: "GET",
            data: {

                mod: "acte",
                act: "getacteprices",
                motif: q
            },
            dataType: "json",
            success: function (data) {
                data = eval(data);
                var html = "";
                if (data.length > 0) {
                    $this.parents('.box').find('.body .table tbody').empty();
                    $this.parents('.box').find('.body .alert').remove();
                    var count = 0;
                    for (var item in data) {
                        count++;
                        html += '<tr class=>\
                                <td>' + count + '</td>\
                                <td>' + data[item].acte + '</td>\
                                <td>' + data[item].category + '</td>\
                                <td>' + data[item].prix_conventionne + '</td>\
                                <td>' + data[item].prix_prive + '</td>\
                                <td>' + data[item].prix_affilier + '</td>\
                                <td>\
                            </td></tr>';
                    }
                    $this.parents('.box').find('.body .table tbody').append(html);

                }
            }
        });
    });


    $('.input-examen-price').on('keyup', function (e) {
        e.preventDefault();
        var $this = $(this);
        var q = $(this).val();
        $.ajax({
            url: "/controls/control.php",
            type: "GET",
            data: {

                mod: "acte",
                act: "getexamenrices",
                motif: q
            },
            dataType: "json",
            success: function (data) {
                data = eval(data);
                var html = "";
                if (data.length > 0) {
                    $this.parents('.box').find('.body .table tbody').empty();
                    $this.parents('.box').find('.body .alert').remove();
                    var count = 0;
                    for (var item in data) {

                        count++;
                        html += '<tr class=>\
                                <td>' + count + '</td>\
                                <td>' + data[item].examen + '</td>\
                                <td>' + data[item].category + '</td>\
                                <td>' + data[item].prixconventionne + '</td>\
                                <td>' + data[item].prixprive + '</td>\
                                <td>' + data[item].prixaffilier + '</td>\
                                <td>\
                            </td></tr>';
                    }
                    $this.parents('.box').find('.body .table tbody').append(html);

                }
            }
        });
    });

    $('.input-search-diagnostic').on('keyup', function (e) {
        e.preventDefault();
        var $this = $(this);
        var q = $(this).val();
        $.ajax({
            url: "/controls/control.php",
            type: "GET",
            data: {
                mod: "acte",
                act: "searchdiagnostic",
                motif: q
            },
            dataType: "json",
            success: function (data) {
                data = eval(data);
                var html = "";
                if (data.length > 0) {
                    $this.parents('.box').find('.body .table tbody').empty();
                    $this.parents('.box').find('.body .alert').remove();

                    var count = 0;
                    for (var item in data) {
                        count++;
                        html += '<tr class=>\
                                <td>' + count + '</td>\
                                <td>' + data[item].id_diagnostic + '</td>\
                                <td>' + data[item].nompatient + " " + data[item].postnompatient + " " + data[item].prenompatient + '</td>\
                                <td>' + data[item].nomagent + " " + data[item].postnomagent + " " + data[item].prenomagent + "<br>(" + data[item].fonction + ")" + '</td>\
                                <td>' + data[item].acte_pose + '</td>\
                                <td>' + data[item].category + '</td>\
                                <td>' + data[item].datediagnostic + '</td>\
                                <td><a href="/public/actes_medicaux.php?action=examen&m=addexamen&id=' + data[item].id_diagnostic + '" class="danger text-danger"><span class="glyphicon glyphicon-list"></span></a>\
                                                        <a href="/public/actes_medicaux.php?action=view&amp;id=' + data[item].id_diagnostic + '"><span class="glyphicon glyphicon-eye-open"></span></a>\
                                                        <a href="" class="danger text-danger"><span class="glyphicon glyphicon-remove"></span></a>\
                            </td></tr>';
                    }
                    $this.parents('.box').find('.body .table tbody').append(html);

                }
            }
        });
    });
    $('.input-search-livraison').on('keyup', function (e) {
        e.preventDefault();
        var $this = $(this);
        var q = $(this).val();
        $.ajax({
            url: "/controls/control.php",
            type: "GET",
            data: {
                mod: "pharmacy",
                act: "searchlivraison",
                motif: q
            },
            dataType: "json",
            success: function (data) {
                data = eval(data);
                var html = "";
                if (data.length > 0) {
                    $this.parents('.box').find('.body .table tbody').empty();
                    $this.parents('.box').find('.body .alert').remove();
                    var count = 0;
                    for (var item in data) {
                        count++;
                        html += '<tr class=>\
                                <td>' + count + '</td>\
                                <td>' + data[item].id_livraison + '</td>\
                                <td>' + data[item].nom + " " + data[item].prenom + " " + data[item].postnom + '(' + data[item].fonction + ') ' + '</td>\
                                <td>' + data[item].datelivraison + '</td>\
                                <td><a href="/public/pharmacy.php?action=livraison&m=listproductlivre&id=' + data[item].id_livraison + '"><span class="glyphicon glyphicon-eye-open"></span></a>\
                                    <a href="/controls/control.php?mod=pharmacy&acte=dellivraison&id=' + data[item].id_livraison + '" class="danger text-danger"><span class="glyphicon glyphicon-remove"></span></a>\
                            </td></tr>';
                    }
                    $this.parents('.box').find('.body .table tbody').append(html);
                }
            }
        });
    });
    $('.input-search-sale').on('keyup', function (e) {
        e.preventDefault();
        var $this = $(this);
        var q = $(this).val();
        $.ajax({
            url: "/controls/control.php",
            type: "GET",
            data: {
                mod: "pharmacy",
                act: "searchsale",
                motif: q
            },
            dataType: "json",
            success: function (data) {
                data = eval(data);
                var html = "";
                if (data.length > 0) {
                    $this.parents('.box').find('.body .table tbody').empty();
                    $this.parents('.box').find('.body .alert').remove();
                    var count = 0;
                    for (var item in data) {
                        count++;
                        html += '<tr class=>\
                                <td>' + count + '</td>\
                                <td>' + data[item].idvente + '</td>\
                                <td>' + data[item].total + '</td>\
                                <td>' + data[item].datevente + '</td>\
                                <td><a href="/public/pharmacy.php?action=sale&id=' + data[item].idvente + '"><span class="glyphicon glyphicon-eye-open"></span></a>\
                                    <a href="/controls/control.php?mod=pharmacy&acte=delsale&id=' + data[item].idvente + '" class="danger text-danger"><span class="glyphicon glyphicon-remove"></span></a>\
                            </td></tr>';
                    }
                    $this.parents('.box').find('.body .table tbody').append(html);
                }
            }
        });
    });

    $('.input-search-approvisionnement').on('keyup', function (e) {
        e.preventDefault();
        var $this = $(this);
        var q = $(this).val();
        $.ajax({
            url: "/controls/control.php",
            type: "GET",
            data: {
                mod: "pharmacy",
                act: "searchsale",
                motif: q
            },
            dataType: "json",
            success: function (data) {
                data = eval(data);
                var html = "";
                if (data.length > 0) {
                    $this.parents('.box').find('.body .table tbody').empty();
                    $this.parents('.box').find('.body .alert').remove();
                    var count = 0;
                    for (var item in data) {
                        count++;
                        html += '<tr class=>\
                                <td>' + count + '</td>\
                                <td>' + data[item].idvente + '</td>\
                                <td>' + data[item].total + '</td>\
                                <td>' + data[item].datevente + '</td>\
                                <td><a href="/public/pharmacy.php?action=sale&id=' + data[item].idvente + '"><span class="glyphicon glyphicon-eye-open"></span></a>\
                                    <a href="/controls/control.php?mod=pharmacy&acte=delsale&id=' + data[item].idvente + '" class="danger text-danger"><span class="glyphicon glyphicon-remove"></span></a>\
                            </td></tr>';
                    }
                    $this.parents('.box').find('.body .table tbody').append(html);
                }
            }
        });
    });
    $('.input-search-product').on('keyup', function (e) {
        e.preventDefault();
        var $this = $(this);
        var q = $(this).val();
        $.ajax({
            url: "/controls/control.php",
            type: "GET",
            data: {
                mod: "pharmacy",
                act: "searchproduct",
                motif: q
            },
            dataType: "json",
            success: function (data) {
                data = eval(data);
                var html = "";
                if (data.length > 0) {
                    $this.parents('.box').find('.body .table tbody').empty();
                    $this.parents('.box').find('.body .alert').remove();
                    var count = 0;
                    for (var item in data) {
                        count++;
                        html += '<tr class=>\
                                <td>' + count + '</td>\
                                <td>\
                                    <a href="/public/pharmacy.php?action=view&id=' + data[item].id + '" ><img src="/img/produit/' + data[item].filename + '.' + data[item].type + '" class="user-profile"/>\
                                    <h5 style="margin: 0; padding: 0">' + data[item].lib + '</h5>\
                                    <span class="mode_conservation">Cond. : ' + data[item].libconservation + '</span>\
                                    <span class="mode_conservation">Forme :' + data[item].forme + '</span></a></td>\
                                    <td>' + data[item].libcategory + '</td>\
                                    <td>' + data[item].quantite + '</td>\
                                    <td>' + data[item].prixachat + '$</td>\
                                    <td>' + data[item].prixvente + '$</td>\
                                    <td>' + data[item].qtealert + '</td>\
                                    <td>' + data[item].dateFab + '</td>\
                                    <td>' + data[item].dateExp + '</td>\
                                    <td><a class="" href="/controls/control.php?mod=pharmacy&act=del&id=' + data[item].id + '"><span class="glyphicon glyphicon-remove"></span></a>\
                                       <a class="text-danger" href="/public/pharmacy.php&action=edit&id=' + data[item].id + '"><span class="glyphicon glyphicon-edit"></span></a>\
                                </td></tr>';
                    }
                    $this.parents('.box').find('.body .table tbody').append(html);
                }
            }
        });
    });

    $('.searchproduct').on('keyup', function (e) {
        e.preventDefault();
        var $this = $(this);
        var q = $(this).val();
        $.ajax({
            url: "/controls/control.php",
            type: "GET",
            data: {

                mod: "pharmacy",
                act: "searchproduct",
                motif: q
            },
            dataType: "json",
            success: function (data) {
                dataJson = eval(data);
                $('.wrapAutocompleListe').hide(10);
                var html = '<div class="wrapAutocompleListe" style=" margin-top : 0px"><ul>';
                for (var item in dataJson) {
                    html += '<li class="item-suggestion" data-product=' + dataJson[item].id + '>';
                    html += '<img src="/img/personnel/' + dataJson[item].filename + "." + dataJson[item].type + '">';
                    html += '<div class="item-suggestion-data">' + dataJson[item].lib + '</h5>';
                    html += '<p>Catégory : ' + dataJson[item].libcategory + '</p>';
                    html += '<p>Cond. : ' + dataJson[item].libconservation + '</p>';
                    html += '<p>Forme : ' + dataJson[item].forme + '</p>';
                    html += '<p>Quantité en stock : ' + dataJson[item].quantite + '</p>';
                    html += '</div>';
                    html += '</li>';
                }
                html += '</ul>';
                html += ' </div> ';
                $(html).insertAfter($this);
            }
        });
    });

    $('.input-search-product-sale').on('keyup', function (e) {
        e.preventDefault();
        var $this = $(this);
        var q = $(this).val();
        $.ajax({
            url: "/controls/control.php",
            type: "GET",
            data: {

                mod: "pharmacy",
                act: "searchproduct",
                motif: q
            },
            dataType: "json",
            success: function (data) {
                dataJson = eval(data);
                $('.wrapAutocompleListe').hide(10);
                var html = '<div class="wrapAutocompleListe" style=" margin-top :38px"><ul>';
                for (var item in dataJson) {
                    html += '<li class="item-suggestion" data-product=' + dataJson[item].id + '>';
                    html += '<img src="/img/produit/' + dataJson[item].filename + "." + dataJson[item].type + '">';
                    html += '<div class="item-suggestion-data">' + dataJson[item].lib + '</h5>';
                    html += '<p>Catégory : ' + dataJson[item].libcategory + '</p>';
                    html += '<p>Cond. : ' + dataJson[item].libconservation + '</p>';
                    html += '<p>Forme: ' + dataJson[item].forme + '</p>';
                    html += '<p>Quantité en stock : ' + dataJson[item].quantite + '</p>';
                    html += '<p>Date Exp : ' + dataJson[item].dateExp + '</p>';
                    html += '<a href="/controls/control.php?mod=pharmacy&act=additemtobasket&id=' + dataJson[item].id + '" class="addProductToBasket btn btn-grad btn-metis-2"><i class="glyphicon glyphicon-plus"></i></a>';
                    html += '</div>';
                    html += '</li>';
                }
                html += '</ul>';
                html += ' </div> ';
                $(html).insertAfter($this);
            }
        });
    });


    $('#formProductSale ').on('click', '.addProductToBasket', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var self = $(this);
        var totatpaydiv = self.parents('#formProductSale').find('#total');
        var netpaydiv = self.parents('#formProductSale').find('#netpay');
        var netpaydivCDF = self.parents('#formProductSale').find('#netpayCDF');
        var total = 0, netpay = 0;
        var monnaie = self.parents('#formProductSale').find('#monnaie');

        var link = $(this).attr('href');
        $.ajax({
            url: link,
            type: "get",
            dataType: 'json',
            success: function (data) {
                data = eval(data);
                switch (data.valider) {
                    case true:
                        var html = "";
                        var count = 0;
                        var productId, productQte, productLib, productPrices, productDateExp;
                        for (var i = 0; i < data.product.products.length; i++) {
                            count++;
                            productId = data.product.products[i];
                            productQte = data.product.qteCmd[i];
                            productPrices = data.product.prixvente[i];
                            productLib = data.product.designation[i];
                            productDateExp = data.product.dateExp[i];
                            total += productPrices * productQte;

                            html += '<tr>\
                                    <td>' + count + '</td>\
                                    <td><a href="/public/pharmacy.php?action=view&amp;id=' + productId + '">\
                                            <h5>' + productLib + '</h5></a></td>\
                                    <td><input style="text-align: center; border: none" type="number" class="qteCmd" data-item="' + productId + '" name="qte" value="' + productQte + '"></td>\
                                    <td>' + productPrices + '</td>\
                                    <td>' + productPrices * productQte + '</td>\
                                    <td>\
                                        <a class="text-danger removefrombasket" href="/controls/control.php?mod=pharmacy&amp;act=removefrombasket&amp;id=' + productId + '"><span class="glyphicon glyphicon-remove"></span></a>\
                                    </td>\
                                </tr>';
                        }
                        $(totatpaydiv).text("").text(total);
                        $(netpaydiv).text("").text(total + ((total * 18) / 100));
                        $(netpaydivCDF).text("").text((total + ((total * 18) / 100)) * data.TAUX);
                        self.parents('#formProductSale').find('#list-product-sold').find('tbody').empty().append(html);
                        break;

                    default:
                        alert(data.message);
                        return  false;
                        break;

                }
            }
        });
    });

    $('#clearbasket').on('click', function (e) {
        e.preventDefault();
        var self = $(this);
        var totatpaydiv = self.parents('#formProductSale').find('#total');
        var netpaydiv = self.parents('#formProductSale').find('#netpay');
        var netpaydivCDF = self.parents('#formProductSale').find('#netpayCDF');
        $.ajax({
            url: "/controls/control.php",
            data: {
                mod: "pharmacy",
                act: "clearbasket"
            },
            dataType: 'json',
            success: function (data) {
                if (data.valider === true) {
                    $(totatpaydiv).text("0");
                    $(netpaydiv).text("0");
                    $(netpaydivCDF).text("0");
                    $('#list-product-sold').find('tbody').empty();
                }
            }
        });
        return false;
    });

    $('#formProductSale ').on('click', '.removefrombasket', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var self = $(this);
        var totatpaydiv = self.parents('#formProductSale').find('#total');
        var netpaydiv = self.parents('#formProductSale').find('#netpay');
        var netpaydivCDF = self.parents('#formProductSale').find('#netpayCDF');
        var total = 0, netpay = 0;
        var monnaie = self.parents('#formProductSale').find('#monnaie');
        var link = $(this).attr('href');
        $.ajax({
            url: link,
            type: "get",
            dataType: 'json',
            success: function (data) {
                data = eval(data);
                switch (data.valider) {
                    case true:
                        var html = "";
                        var count = 0;
                        var productId, productQte, productLib, productPrices, productDateExp;
                        for (var i = 0; i < data.product.products.length; i++) {
                            count++;
                            productId = data.product.products[i];
                            productQte = data.product.qteCmd[i];
                            productPrices = data.product.prixvente[i];
                            productLib = data.product.designation[i];
                            productDateExp = data.product.dateExp[i];
                            total += productPrices * productQte;

                            html += '<tr>\
                                    <td>' + count + '</td>\
                                    <td><a href="/public/pharmacy.php?action=view&amp;id=' + productId + '">\
                                            <h5>' + productLib + '</h5></a></td>\
                                    <td><input style="text-align: center; border: none" type="number" class="qteCmd" data-item="' + productId + '" name="qte" value="' + productQte + '"></td>\
                                    <td>' + productPrices + '</td>\
                                    <td>' + productPrices * productQte + '</td>\
                                    <td>\
                                        <a class="text-danger removefrombasket" href="/controls/control.php?mod=pharmacy&amp;act=removefrombasket&amp;id=' + productId + '"><span class="glyphicon glyphicon-remove"></span></a>\
                                    </td>\
                                </tr>';

                        }
                        $(totatpaydiv).text("").text(total);
                        $(netpaydiv).text("").text(total + ((total * 18) / 100));
                        $(netpaydivCDF).text("").text((total + ((total * 18) / 100)) * data.TAUX);
                        self.parents('#formProductSale').find('#list-product-sold').find('tbody').empty().append(html);
                        break;

                    default:
                        alert(data.message);
                        return  false;
                        break;

                }
            }
        });
    });

    $('#formProductSale ').on('change', '.qteCmd', function (e) {
        e.preventDefault();
        e.stopPropagation();
        let self = $(this);
        var totatpaydiv = self.parents('#formProductSale').find('#total');
        var netpaydiv = self.parents('#formProductSale').find('#netpay');
        var netpaydivCDF = self.parents('#formProductSale').find('#netpayCDF');
        var total = 0, netpay = 0;
        var monnaie = self.parents('#formProductSale').find('#monnaie');
        var qtecmd = self.val();
        var trthis = self.parents('tr');
        $.ajax({
            url: "/controls/control.php",
            type: "get",
            data: {
                mod: "pharmacy",
                act: "changequantity",
                qte: qtecmd,
                item: self.attr('data-item')
            },
            dataType: 'json',
            success: function (data) {
                data = eval(data);
                switch (data.valider) {
                    case true:
                        var html = "";
                        var count = 0;
                        var productId, productQte, productLib, productPrices, productDateExp;
                        for (var i = 0; i < data.product.products.length; i++) {
                            count++;
                            productId = data.product.products[i];
                            productId = data.product.products[i];
                            productQte = data.product.qteCmd[i];
                            productPrices = data.product.prixvente[i];
                            productLib = data.product.designation[i];
                            productDateExp = data.product.dateExp[i];
                            total += productPrices * productQte;
                            if (productId == self.attr('data-item')) {
                                html += '<tr>\
                                    <td>' + count + '</td>\
                                    <td><a href="/public/pharmacy.php?action=view&amp;id=' + productId + '">\
                                            <h5>' + productLib + '</h5></a></td>\
                                    <td><input style="text-align: center; border: none" type="number" class="qteCmd" data-item="' + productId + '" name="qte" value="' + productQte + '"></td>\
                                    <td>' + productPrices + '</td>\
                                    <td>' + productPrices * productQte + '</td>\
                                    <td>\
                                        <a class="text-danger removefrombasket" href="/controls/control.php?mod=pharmacy&amp;act=removefrombasket&amp;id=' + productId + '"><span class="glyphicon glyphicon-remove"></span></a>\
                                    </td>\
                                    </tr>';
                            }
                        }
                        $(trthis).replaceWith(html);
                        $(totatpaydiv).text("").text(total);
                        $(netpaydivCDF).text("").text((total + ((total * 18) / 100)) * data.TAUX);
                        $(netpaydiv).text("").text(total + ((total * 18) / 100));
                        break;
                    default:
                        alert(data.msg);
                        $(self).val(qtecmd.toString());
                        console.log(qtecmd.toString());
                        return  false;
                        break;
                }
            }
        });
    });
    /*
     $('#formProductSale ').on('change', '#monnaie', function(e){
     e.preventDefault();
     e.stopPropagation();
     var self = $(this);
     var totatpaydiv = self.parents('#formProductSale').find('#total');
     var netpaydiv = self.parents('#formProductSale').find('#netpay');
     var total =0, netpay =0;
     var monnaie = self.parents('#formProductSale').find('#monnaie');
     var money = $(this).val();
     $.ajax({
     url : "/controls/control.php",
     type : "get",
     data :{
     mod : "pharmacy",
     act : "changerMoney",
     money : money               
     },
     dataType: 'json',
     success : function (data) {   
     data = eval(data);                
     switch (data.valider) {
     case true:                            
     var html = "";
     var count = 0;
     var productId, productQte, productLib, productPrices, productDateExp;
     for (var i = 0; i < data.product.products.length; i++) {count++;
     productId = data.product.products[i];
     productQte = data.product.qteCmd[i];
     productPrices = data.product.prixvente[i];
     productLib =  data.product.designation[i];
     productDateExp =  data.product.dateExp[i];
     total += productPrices * productQte;                                
     html += '<tr>\
     <td>'+count+'</td>\
     <td><a href="/public/pharmacy.php?action=view&amp;id='+productId+'">\
     <h5>'+productLib+'</h5></a></td>\
     <td><input style="text-align: center; border: none" type="number" class="qteCmd" data-item="'+productId+'" name="qte" value="'+productQte+'"></td>\
     <td>'+productPrices+'</td>\
     <td>'+productPrices * productQte +'</td>\
     <td>\
     <a class="text-danger removefrombasket" href="/controls/control.php?mod=pharmacy&amp;act=removefrombasket&amp;id='+productId+'"><span class="glyphicon glyphicon-remove"></span></a>\
     </td>\
     </tr>';
     
     }
     $(totatpaydiv).text("").text(total);
     $(netpaydiv).text("").text(total + ((total * 18)/100));
     self.parents('#formProductSale').find('#list-product-sold').find('tbody').empty().append(html);                            
     break;
     
     default:      
     alert(data.message);
     return  false;
     break;
     
     }
     }
     });
     });*/

    $('#formProductSale ').on('click', '#btnFacturer', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var self = $(this);
        var totatpaydiv = self.parents('#formProductSale').find('#total');
        var netpaydiv = self.parents('#formProductSale').find('#netpay');
        var total = 0, netpay = 0;
        var monnaie = self.parents('#formProductSale').find('#monnaie');
        var money = $(this).val();
        $.ajax({
            url: "/controls/control.php",
            type: "get",
            data: {
                mod: "pharmacy",
                act: "valider"
            },
            dataType: 'json',
            success: function (data) {
                data = eval(data);
                switch (data.valider) {
                    case true:
                        window.open("/public/printfacture.php?id=" + data.idFacture, "Impression facture", "toolbar=no, resizable=no, height=500,width=945");
                        var html = "";
                        var count = 0;
                        var productId, productQte, productLib, productPrices, productDateExp;
                        $(totatpaydiv).text("").text(total);
                        $(netpaydiv).text("").text(total + ((total * 18) / 100));
                        self.parents('#formProductSale').find('#list-product-sold').find('tbody').empty().append(html);
                        $('#clearbasket').trigger("click");
                        break;
                    default:
                        alert(data.msg);
                        return  false;
                        break;
                }
            }
        });
    });
    $('.printpage').click(
            function (e) {
                e.preventDefault();
                print();
                return false;
            });

    $('#myModal').on('show.bs.modal', function (e) {
        $('#clearbasket').trigger("click");
    });

    $('.printbtn').click(
            function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                window.open(url, "Impression Géton", "toolbar=no, resizable=no, height=500,width=945");
                return false;
            });

    $('#addAntecedent').on('submit', function (e) {
        e.preventDefault();
        var form = $(this).get(0);
        var formModal = $(this);
        var formdata = new FormData(form);
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'json',
            data: formdata,
            'processData': false,
            'contentType': false,
            success: function (data, textStatus, jqXHR) {
                data = eval(data);
                if (data.valide == true) {
                    location.reload();
                } else {
                    formModal.find('.modal-body').find('#wrapAlert').remove();
                    let html = $('<div class="row" id="wrapAlert">\
                                            <div class="col-md-12">\
                                                <div class="alert alert-danger">\
                                                </div>\
                                            </div>\
                                        </div>');
                    $.each(data.error, function (i, ele) {
                        html.find('.alert').append("<p>" + ele + "</p>");
                    });
                    formModal.find('.modal-body').prepend(html);
                    false;
                }
            }
        }
        );
        return false;
    });
    $("body").on('click', "#confirm-structure-actes", function (e) {
        e.preventDefault();
        e.stopPropagation();
        let tab = [];
        let selectedActes = $('.selected-acte:checked');
        if (selectedActes.length > 0) {
            selectedActes.each(function (i, e) {
                if ($(e).attr("data-id")) {
                    tab.push($(e).attr("data-id"));
                } else {

                }

            });

            $.ajax({
                url: "/controls/control.php?mod=Structureaffilie&act=addActesToStructure&id=" + $("#id_structure").val(),
                type: "POST",
                data: {
                    actes: JSON.stringify(tab),
                    id: $("#id_structure").val()
                },
                dataType: "json",
                error: function (jqXHR, textStatus, errorThrown) {
                    jQuery.MessageBox("Une erreur est surgie");
                }, success: function (data, textStatus, jqXHR) {
                    console.log(data);
                    try {
                        //data = JSON.parse(data);
                        location.href = "/public/structures_affilies.php?action=view&id=" + data.id;
                    } catch (exception) {
                        console.log(exception);
                        location.href = "/public/structures_affilies.php";
                    }

                }
            });
        } else {
            $.MessageBox("Aucun acte n'a été sélectionné");
        }
    });

});

