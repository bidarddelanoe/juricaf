<?php
use_helper('Text');

$natureConstit = array(
      "QPC" => "Question prioritaire de constitutionnalité",
      "DC" => "Contrôle de constitutionnalité des lois ordinaires, lois organiques, des traités, des règlements des Assemblées",
      "LP" => "Contrôle de constitutionnalité des lois du pays de Nouvelle-Calédonie",
      "L" => "Déclassements de textes législatifs au rang réglementaire",
      "FNR" => "Fins de non-recevoir",
      "LOM" => "Répartitions des compétences entre l'État et certaines collectivités d'outre-mer",
      "AN" => "Élections à l'Assemblée nationale",
      "SEN" => "Élections au Sénat",
      "PDR" => "Élection présidentielle",
      "REF" => "Référendums",
      "ELEC" => "Divers élections : observations",
      "ELECT" => "Divers élections : observations",
      "D" => "Déchéance de parlementaires",
      "I" => "Incompatibilité des parlementaires",
      "AR16" => "Article 16 de la Constitution (pouvoirs exceptionnels du Président de la République)",
      "NOM" => "Nomination des membres",
      "RAPP" => "Nomination des rapporteurs-adjoints",
      "ORGA" => "Décision d'organisation du Conseil constitutionnel",
      "AUTR" => "Autres décisions"
      );

function replaceAccents($string) {
    $table = array(
        'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
        'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
        'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
        'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
        'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
        'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
        'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r',
    );
    return strtr($string, $table);
}

function replaceBlank($str) {
  return str_replace (' ', '_', $str);
}

if(isset($document->references)) {
  foreach ($document->getReferences() as $values) {
    $i = 0;
    if(is_array($values) || is_object($values)) {
      foreach($values as $keys => $value) {
        if(is_array($value) || is_object($value)) {
          if(isset($value['type'])) {
            foreach ($value as $key => $vals) {
              if($vals !== $value['type']) {
                $references[$value['type']][$i][$key] = $vals;
              }
            }
          }
        }
        else {
          if($value !== $values['type']) {
            $references[$values['type']][0][$keys] = $value;
          }
        }
      $i++;
      }
    }
  }
}

// ECLI //

$code_pays_euro = array(
      "Belgique" => "BE",
      "Bulgarie" => "BG",
      "République tchèque" => "CZ",
      "Danemark" => "DK",
      "Allemagne" => "DE",
      "Estonie" => "EE",
      "Irlande" => "IE",
      "Grèce" => "EL",
      "Espagne" => "ES",
      "France" => "FR",
      "Italie" => "IT",
      "Chypre" => "CY",
      "Lettonie" => "LV",
      "Lituanie" => "LT",
      "Luxembourg" => "LU",
      "Hongrie" => "HU",
      "Malte" => "MT",
      "Pays-bas" => "NL",
      "Autriche" => "AT",
      "Pologne" => "PL",
      "Portugal" => "PT",
      "Roumanie" => "RO",
      "Slovénie" => "SI",
      "Slovaquie" => "SK",
      "Finlande" => "FI",
      "Suède" => "SE",
      "Royaume-uni" => "UK",
      "Union européenne" => "EU"
      );
// http://publications.europa.eu/code/fr/fr-370100.htm

$abbr_juridiction = array(
      "Haute cour de cassation et de justice" => "HCCJ", // Roumanie
      "Cour supérieure de justice" => "CSJ", // Luxembourg
      "Cour constitutionnelle" => "CC", // Luxembourg
      "Cour suprême" => "CS", // Hongrie
      "Tribunal des conflits" => "TC",
      "Cour de discipline budgétaire et financière" => "CDBF",
      "Cour de cassation" => "CCASS",
      "Conseil d'état" => "CE",
      "Conseil constitutionnel" => "CC",
      "Cour suprême de cassation" => "CSC", // Bulgarie
      "Cour d'arbitrage" => "CA", // Belgique
      "Cour de justice de l'union européenne" => "CJUE"
      );

//////////////////////

$contributors = '';

  if(isset($document->president) || isset($document->avocat_gl) || isset($document->rapporteur) || isset($document->commissaire_gvt) || isset($document->avocats)) {
    if (isset($document->president)) {
      $contributors .= 'Président : <em>'.$document->president.'</em><br />'; // replace br par ' ; '
    }
    if (isset($document->avocat_gl)) {
      $contributors .= 'Avocat général : <em>'.$document->avocat_gl.'</em><br />';
    }
    if (isset($document->rapporteur)) {
      $contributors .= 'Rapporteur : <em>'.$document->rapporteur.'</em><br />';
    }
    if (isset($document->commissaire_gvt)) {
      $contributors .= 'Commissaire gouvernement : <em>'.$document->commissaire_gvt.'</em><br />';
    }
    if (isset($document->avocats)) {
      $contributors .= 'Avocats : <em>'.$document->avocats.'</em><br />';
    }
    $contrib = true;
  }

//////////////////////

/*
- Description : les sommaires
- Mots-clés: Mettre les mots clés des titres principaux et secondaires
 * */

$keywords = '';
$analyses = '';
$citations_analyses = '';

if (isset($document->analyses)) {
  if (isset($document->analyses['analyse'])) {
    foreach($document->analyses['analyse'] as $key => $values) {
      if(is_array($values) || is_object($values)) {
        foreach($values as $key => $value) {
          if($value !== "null") {
            $analyses .= '<blockquote>';
            if(strpos($key, 'titre') !== false) { $analyses .= '<h2>'; $keywords .= $value.' '; }
            else { $analyses .= '<p>'; }
            $analyses .=  $value;
            if(strpos($key, 'titre') !== false) { $analyses .= '</h2>'; }
            else { $analyses .= '</p>'; }
            $analyses .= '</blockquote>';
          }
        }
      }
      else {
        if($values !== "null") {
          $analyses .= '<blockquote>';
          if(strpos($key, 'titre') !== false) { $analyses .= '<h2>';  $keywords .= $values.' '; }
          $analyses .= $values;
          if(strpos($key, 'titre') !== false) { $analyses .= '</h2>'; }
          $analyses .= '</blockquote>';
        }
      }
    }
    if(isset($references['CITATION_ANALYSE'])) {
      foreach($references['CITATION_ANALYSE'] as $value) {
        if(isset($value['nature'], $value['date'], $value['titre'])) {
          $titre = $value['nature'].' du '.$value['date'].' sur '.$value['titre'];
        }
        else { $titre = $value['titre']; }
        if(isset($value['url'])) {
          $citations_analyses .= '<a href="'.$value['url'].'">'.$titre.'</a><br />';
        }
        else { $citations_analyses .= $titre.'<br />'; }
      }
    }
  }
}

//////////////////////

$citations_arret = '';
$sources = '';

if(isset($references['CITATION_ARRET']) || isset($references['SOURCE'])) {
  if(isset($references['CITATION_ARRET'])) {
    foreach($references['CITATION_ARRET'] as $value) {
      if(isset($value['nature'], $value['date'], $value['titre'])) {
        $titre = $value['nature'].' du '.$value['date'].' sur '.$value['titre'];
      }
      else { $titre = $value['titre']; }
      if(isset($value['url'])) {
        $citations_arret .= '<a href="'.$value['url'].'">'.$titre.'</a><br />';
      }
      else { $citations_arret .=  $titre.'<br />'; }
    }
  }

  if(isset($references['SOURCE'])) {
    foreach($references['SOURCE'] as $value) {
      if(isset($value['nature'], $value['date'], $value['titre'])) {
        $titre = $value['nature'].' du '.$value['date'].' sur '.$value['titre'];
      }
      else { $titre = $value['titre']; }
      if(isset($value['url'])) {
        $sources .= '<a href="'.$value['url'].'">'.$titre.'</a><br />';
      }
      else { $sources .= $titre.'<br />'; }
    }
  }
}

if (array_key_exists($document->pays, $code_pays_euro) && array_key_exists($document->juridiction, $abbr_juridiction)) {

  $ecli = 'ECLI:'.$code_pays_euro[$document->pays].':'.$abbr_juridiction[$document->juridiction].':'.substr($document->date_arret, 0, 4).':'.$document->num_arret;

  $creator = $document->juridiction;
  if(isset($document->section)) { $creator .= ' '.$document->section; }

  $citations = '';

  if (!empty($citations_analyses)) { $citations .= $citations_analyses; }
  if (!empty($citations_arret)) { $citations .= $citations_arret; }
  if (!empty($sources)) { $citations .= $sources; }


  //$sf_response->auto_discovery_link_tag(false, 'http://purl.org/dc/elements/1.1/', 'rel="schema.DC"');
  //<link rel="schema.DC" href="http://purl.org/dc/elements/1.1/" />
  //<link rel="schema.DCTERMS" href="http://purl.org/dc/terms/" />

  // Obligatoire
  $sf_response->addMeta('DC.format', 'text/html; charset=utf-8', false, false, false);
  $sf_response->addMeta('DC.identifier', $sf_request->getUri(), false, false, false);
  $sf_response->addMeta('DC.isVersionOf', $ecli, false, false, false);
  $sf_response->addMeta('DC.creator', $creator, false, false, false);
  $sf_response->addMeta('DC.coverage', $document->pays, false, false, false);
  $sf_response->addMeta('DC.date', $document->date_arret, false, false, false);
  $sf_response->addMeta('DC.language', 'FR', false, false, false);
  $sf_response->addMeta('DC.publisher', 'AHJUCAF', false, false, false);
  $sf_response->addMeta('DC.accessRights', 'public', false, false, false);
  $sf_response->addMeta('DC.type', 'judicial decision', false, false, false);

  // Facultatif
  // $sf_response->addMeta('DC.title', 'Noms des parties', false, false, false);
  if(isset($document->type_affaire)) {
    $sf_response->addMeta('DC.subject', 'Affaire '.strtolower($document->type_affaire), false, false, false);
  }
  if(!empty($analyses)) {
    $sf_response->addMeta('DC.abstract', "Analyses : \n".strip_tags(str_replace('</blockquote>', " \n", $analyses)), false, false, false);
  }
  if(!empty($keywords)) {
    $sf_response->addMeta('DC.description', strip_tags(str_replace('</blockquote>', " ", $keywords)), false, false, false);
  }
  if(isset($contrib)) {
    $sf_response->addMeta('DC.contributor', strip_tags(str_replace('<br />', " ;\n", $contributors)), false, false, false);
  }
  //$sf_response->addMeta('DC.issued', 'Date de publication', false, false, false);
  if (!empty($citations)) {
    $sf_response->addMeta('DC.references', strip_tags(str_replace('<br />', " ;\n", $citations)), false, false, false);
  }
  // $sf_response->addMeta('DC.isReplacedBy', 'En cas de renumérotation', false, false, false);
}
////////////////
// urn:lex
////////////////

$urnlex_reserved = array(
      "%",
      "/",
      "?",
      "#",
      "@",
      "$",
      ":",
      ";",
      "+",
      ",",
      "~",
      "*",
      "!"
      );

$urnlex_unauthorized = array(
      " de la ",
      " et de ",
      " de l'",
      " des ",
      " de ",
      " d'",
      " et "
      );

$pays_iso3166 = array(
      "Afghanistan" => "AF",
      "Afrique du sud" => "ZA",
      //"Aland, îles" => "AX",
      "Albanie" => "AL",
      "Algérie" => "DZ",
      "Allemagne" => "DE",
      "Andorre" => "AD",
      "Angola" => "AO",
      "Anguilla" => "AI",
      "Antarctique" => "AQ",
      "Antigua-et-barbuda" => "AG",
      "Arabie saoudite" => "SA",
      "Argentine" => "AR",
      "Arménie" => "AM",
      "Aruba" => "AW",
      "Australie" => "AU",
      "Autriche" => "AT",
      "Azerbaïdjan" => "AZ",
      "Bahamas" => "BS",
      "Bahreïn" => "BH",
      "Bangladesh" => "BD",
      "Barbade" => "BB",
      "Bélarus" => "BY",
      "Belgique" => "BE",
      "Belize" => "BZ",
      "Bénin" => "BJ",
      "Bermudes" => "BM",
      "Bhoutan" => "BT",
      "Bolivie" => "BO",
      //"bonaire, saint-eustache et saba" => "BQ",
      "Bosnie-herzégovine" => "BA",
      "Botswana" => "BW",
      //"bouvet, île" => "BV",
      "Brésil" => "BR",
      "Brunéi-darussalam" => "BN",
      "Bulgarie" => "BG",
      "Burkina faso" => "BF",
      "Burundi" => "BI",
      //"Caïmanes, îles" => "KY",
      "Cambodge" => "KH",
      "Cameroun" => "CM",
      "Canada" => "CA",
      "Cap-vert" => "CV",
      //"centrafricaine, république" => "CF",
      "Centrafrique" => "CF",
      "Chili" => "CL",
      "Chine" => "CN",
      //"christmas, île" => "CX",
      "Chypre" => "CY",
      //"cocos (keeling), îles" => "CC",
      "Colombie" => "CO",
      "Comores" => "KM",
      "Congo" => "CG",
      "Congo démocratique" => "CD",
      //"Cook, îles" => "CK",
      //"Corée, république de" => "KR",
      //"Corée, république populaire démocratique de" => "KP",
      "Costa rica" => "CR",
      "Côte d-ivoire" => "CI",
      "Croatie" => "HR",
      "Cuba" => "CU",
      "Curaçao" => "CW",
      "Danemark" => "DK",
      "Djibouti" => "DJ",
      //"dominicaine, république" => "DO",
      "Dominique" => "DM",
      "Égypte" => "EG",
      //"el Salvador" => "SV",
      "Émirats arabes unis" => "AE",
      "Équateur" => "EC",
      "Érythrée" => "ER",
      "Espagne" => "ES",
      "Estonie" => "EE",
      "États-unis" => "US",
      "Éthiopie" => "ET",
      //"Falkland, îles (mal vinas)" => "FK",
      //"féroé, îles" => "FO",
      "Fidji" => "FJ",
      "Finlande" => "FI",
      "France" => "FR",
      "Gabon" => "GA",
      "Gambie" => "GM",
      "Géorgie" => "GE",
      //"Géorgie du sud et les îles sandwich du sud" => "GS",
      "Ghana" => "GH",
      "Gibraltar" => "GI",
      "Grèce" => "GR",
      "Grenade" => "GD",
      "Groenland" => "GL",
      "Guadeloupe" => "GP",
      "Guam" => "GU",
      "Guatemala" => "GT",
      "Guernesey" => "GG",
      "Guinée" => "GN",
      "Guinée-bissau" => "GW",
      "Guinée équatoriale" => "GQ",
      "Guyane" => "GY",
      "Guyane française" => "GF",
      "Haïti" => "HT",
      //"heard, île et mcdonald, îles" => "HM",
      "Honduras" => "HN",
      "Hong-kong" => "HK",
      "Hongrie" => "HU",
      "Île de man" => "IM",
      //"îles mineures éloignées des états-unis" => "UM",
      //"îles vierges britanniques" => "VG",
      //"îles vierges des états-unis" => "VI",
      "Inde" => "IN",
      "Indonésie" => "ID",
      "Iran" => "IR",
      "Iraq" => "IQ",
      "Irlande" => "IE",
      "Islande" => "IS",
      "Israël" => "IL",
      "Italie" => "IT",
      "Jamaïque" => "JM",
      "Japon" => "JP",
      "Jersey" => "JE",
      "Jordanie" => "JO",
      "Kazakhstan" => "KZ",
      "Kenya" => "KE",
      "Kirghizistan" => "KG",
      "Kiribati" => "KI",
      "Koweït" => "KW",
      //"Lao, république démocratique populaire" => "LA",
      "Lesotho" => "LS",
      "Lettonie" => "LV",
      "Liban" => "LB",
      "Libéria" => "LR",
      "libye" => "LY",
      "Liechtenstein" => "LI",
      "Lituanie" => "LT",
      "Luxembourg" => "LU",
      "Macao" => "MO",
      "Macédoine" => "MK",
      "Madagascar" => "MG",
      "Malaisie" => "MY",
      "Malawi" => "MW",
      "Maldives" => "MV",
      "Mali" => "ML",
      "Malte" => "MT",
      //"Mariannes du nord, îles" => "MP",
      "Maroc" => "MA",
      "Marshall, îles" => "MH",
      "Martinique" => "MQ",
      "Maurice" => "MU",
      "Mauritanie" => "MR",
      "Mayotte" => "YT",
      "Mexique" => "MX",
      //"Micronésie, états fédérés de" => "FM",
      //"moldova, république de" => "MD",
      "Monaco" => "MC",
      "Mongolie" => "MN",
      "Monténégro" => "ME",
      "Montserrat" => "MS",
      "Mozambique" => "MZ",
      "Myanmar" => "MM",
      "Namibie" => "NA",
      "Nauru" => "NR",
      "Népal" => "NP",
      "Nicaragua" => "NI",
      "Niger" => "NE",
      "Nigeria" => "NG",
      "Niué" => "NU",
      //"norfolk, île" => "NF",
      "Norvège" => "NO",
      "Nouvelle-Calédonie" => "NC",
      "Nouvelle-Zélande" => "NZ",
      //"océan indien, territoire britannique de l'" => "IO",
      "Oman" => "OM",
      "Ouganda" => "UG",
      "Ouzbékistan" => "UZ",
      "Pakistan" => "PK",
      "Palaos" => "PW",
      //"palestinien occupé, territoire" => "PS",
      "Panama" => "PA",
      "Papouasie-nouvelle-guinée" => "PG",
      "Paraguay" => "PY",
      "Pays-bas" => "NL",
      "Pérou" => "PE",
      "Philippines" => "PH",
      "Pitcairn" => "PN",
      "Pologne" => "PL",
      "Polynésie française" => "PF",
      "Porto rico" => "PR",
      "Portugal" => "PT",
      "Qatar" => "QA",
      "Réunion" => "RE",
      "Roumanie" => "RO",
      "Royaume-uni" => "GB",
      //"Russie, fédération de" => "RU",
      "Russie" => "RU",
      "Rwanda" => "RW",
      "Sahara occidental" => "EH",
      "Saint-barthélemy" => "BL",
      //"sainte-hélène, ascension et tristan da cunha" => "SH",
      "Sainte-lucie" => "LC",
      "Saint-kitts-et-nevis" => "KN",
      "Saint-marin" => "SM",
      //"Saint-martin (partie française)" => "MF",
      //"Saint-martin (partie néerlandaise)" => "SX",
      "Saint-pierre-et-miquelon" => "PM",
      //"Saint-siège (état de la cité du vatican)" => "VA",
      //"Saint-vincent-et-les grenadines" => "VC",
      //"Salomon, îles" => "SB",
      "Samoa" => "WS",
      //"Samoa américaines" => "AS",
      "Sao tomé et principe" => "ST",
      "Sénégal" => "SN",
      "Serbie" => "RS",
      "Seychelles" => "SC",
      "Sierra leone" => "SL",
      "Singapour" => "SG",
      "Slovaquie" => "SK",
      "Slovénie" => "SI",
      "Somalie" => "SO",
      "Soudan" => "SD",
      "Sri Lanka" => "LK",
      "Suède" => "SE",
      "Suisse" => "CH",
      "Suriname" => "SR",
      //"Svalbard et île jan mayen" => "SJ",
      "Swaziland" => "SZ",
      //"Syrienne, république arabe" => "SY",
      "Syrie" => "SY",
      "Tadjikistan" => "TJ",
      //"Taïwan, province de chine" => "TW",
      "Taïwan" => "TW",
      //"Tanzanie, république-unie de" => "TZ",
      "Tanzanie" => "TZ",
      "Tchad" => "TD",
      //"tchèque, république" => "CZ",
      "Terres australes françaises" => "TF",
      "Thaïlande" => "TH",
      "Timor-leste" => "TL",
      "Togo" => "TG",
      "Tokelau" => "TK",
      "Tonga" => "TO",
      "Trinité-et-Tobago" => "TT",
      "Tunisie" => "TN",
      "Turkménistan" => "TM",
      //"turks et caïques, îles" => "TC",
      "Turquie" => "TR",
      "Tuvalu" => "TV",
      "Ukraine" => "UA",
      "Uruguay" => "UY",
      "Vanuatu" => "VU",
      "Venezuela, république bolivarienne du" => "VE",
      "Venezuela" => "VE",
      "Viet nam" => "VN",
      "Wallis et Futuna" => "WF",
      "Yémen" => "YE",
      "Zambie" => "ZM",
      "Zimbabwe" => "ZW"
      );
// ISO 3166-1 : http://www.iso.org/iso/fr/country_codes/iso_3166_code_lists.htm

if (array_key_exists($document->pays, $pays_iso3166)) {

  $juridiction = str_replace($urnlex_unauthorized, " ", $document->juridiction);
  $juridiction = str_replace(" ", ".", $juridiction);
  $juridiction = replaceAccents($juridiction);

  if(array_key_exists($document->type_affaire, $natureConstit)) {
    $type = $document->type_affaire;
  }
  else {
    $type = $document->type;
  }

  $num = str_replace($urnlex_reserved, "", $document->num_arret);

  $urnlex = strtolower('urn:lex;'.$code_pays_euro[$document->pays].';'.$juridiction.';'.$type.';'.$document->date_arret.';'.$num);
}
?>
  <div class="arret">
    <h1><?php echo '<img class="drapeau" src="/images/drapeaux/'.urlencode(replaceBlank($document->pays)).'.png" alt="§" /> '.$document->titre; ?></h1>
    <?php
    if (isset($document->titre_supplementaire)) {
      echo '<h2>'.$document->titre_supplementaire.'</h2>';
    }
    if (isset($document->section)) {
      echo '<h3>'.$document->section.'</h3>';
    }
    if (isset($document->sens_arret)) {
      echo 'Sens de l\'arrêt : <em>'.$document->sens_arret.'</em><br />';
    }
    if (isset($document->type_affaire)) {
      if(isset($natureConstit[$document->type_affaire])) {
        echo 'Type d\'affaire : <em>'.$natureConstit[$document->type_affaire].'</em><br />';
      }
      else {
        echo 'Type d\'affaire : <em>'.$document->type_affaire.'</em><br />';
      }
    }
    if (isset($document->type_recours)) {
      echo 'Type de recours : <em>'.$document->type_recours.'</em><br />';
    }
    echo '<br />';
    if (isset($ecli)) {
      echo 'Identifiant ECLI : <em>'.$ecli.'</em> (non officiel) <img src="/images/aide.png" alt="?" style="margin-bottom: -3px; cursor: pointer;" title="Identifiant européen de la jurisprudence" /><br />';
    }

    if (isset($urnlex)) {
      echo 'Identifiant URN:LEX : <em>'.$urnlex.'</em> <img src="/images/aide.png" alt="?" style="margin-bottom: -3px; cursor: pointer;" title="A Uniform Resource Name (URN) Namespace for Sources of Law (LEX)" /><br />';
    }

    if (!empty($analyses)) {
      echo '<hr /><h3>Analyses : </h3>';
      echo $analyses;
    }
    if (!empty($citations_analyses)) {
      echo '<blockquote><p><em>Références :</em><br />'.$citations_analyses.'</p></blockquote>';
    }

    if (isset($document->saisines)) {
      echo '<hr />';
      echo '<h3>Saisine : </h3>';
      if (isset($document->saisines['saisine'])) {
        foreach($document->saisines['saisine'] as $key => $values) {
          echo '<div>';
          if(is_array($values) || is_object($values)) {
            foreach($values as $key => $value) {
              echo '<blockquote><p>';
              echo $value;
              echo '</p></blockquote>';
            }
          }
          else {
            echo '<blockquote><p>';
              echo $values;
              echo '</p></blockquote>';
          }
        }
        echo '</div>';
      }
    }

    if (isset($document->parties)) {
      echo '<hr />';
      echo '<h3>Parties : </h3>';
      if (isset($document->parties['demandeurs'])) {
        echo 'Demandeurs : ';
        $sep = ''; $i = 1;
        foreach($document->parties['demandeurs'] as $value) {
          if($i > 1) { $sep = ', '; }
          echo '<em>'.$sep.$value.'</em>'; $i++;
        }
        echo '<br />';
      }
      if (isset($document->parties['defendeurs'])) {
        echo 'Défendeurs : ';
        $sep = ''; $i = 1;
        foreach($document->parties['defendeurs'] as $value) {
          if($i > 1) { $sep = ', '; }
          echo '<em>'.$sep.$value.'</em>'; $i++;
        }
        echo '<br />';
      }
    }

    echo '<hr />';

    if($document->pays == "Madagascar" && $document->juridiction == "Cour suprême" && trim($document->texte_arret) == "En haut a droite, cliquez sur PDF pour visualiser le fac-simile de la décision") {
    ?>
    <object data="http://www.juricaf.org/Juricaf/Arrets/Madagascar/Cour%20supr%C3%AAme/<?php echo $document->juricaf_id; ?>.PDF" type="application/pdf" width="100%" height="1000" navpanes="0" statusbar="0" messages="0">
    Cette décision est disponible au format pdf : <a href="http://www.juricaf.org/Juricaf/Arrets/Madagascar/Cour%20supr%C3%AAme/<?php echo $document->juricaf_id; ?>.PDF"><?php echo $document->titre; ?></a>
    </object>
    <?php
    }
    else {
      echo '<h3>Texte : </h3>';
      echo simple_format_text(trim($document->texte_arret));
    }
    if (!empty($citations_arret) || !empty($sources)) {
      echo '<p><em>Références : </em><br />';
      if (!empty($citations_arret)) { echo $citations_arret; }
      if (!empty($sources)) { echo $sources; }
      echo '</p>';
    }

    if(isset($document->nor) || isset($document->ecli) || isset($document->numeros_affaires)) {
      echo '<hr />';
      if (isset($document->nor)) {
        echo 'Numéro NOR : <em>'.$document->nor.'</em><br />';
      }
      if (isset($document->ecli)) {
        echo 'Numéro ECLI : <em>'.$document->ecli.'</em><br />';
      }
      if (isset($document->numeros_affaires)) {
        $sep = ''; $i = 0;
        foreach($document->numeros_affaires as $values) {
          if(is_array($values) || is_object($values)) {
            foreach($values as $value) {
              if($i > 0) { $sep = ', '; }
              $numeros = $sep.$value; $i++;
            }
          }
          else {
            if($i > 0) { $sep = ', '; }
            $numeros = $sep.$values; $i++;
          }
        }
        if($i > 1) { $s = 's'; } else { $s = ''; }
        echo 'Numéro d\'affaire'.$s.' : <em>'.$numeros.'</em><br />';
      }
    }

    if(isset($references['PUBLICATION'])) {
      echo '<hr /><h3>Publications :</h3>';
        foreach($references['PUBLICATION'] as $value) {
          if(isset($value['url'])) {
            echo '<a href="'.htmlentities($value['url']).'">'.$value['titre'].'</a><br />';
          }
          else { echo $value['titre'].'<br />'; }
        }
    }

    if(isset($contrib)) {
      echo '<hr /><h3>Composition du Tribunal :</h3>'.$contributors;
    }

    if (isset($document->fonds_documentaire)) {
      echo '<hr /><p>Origine : <em>'.$document->fonds_documentaire.'</em></p><br />';
    }
    ?>
  </div>
  <div class="extra">
    <a href="/couchdb/_utils/document.html?<?php echo sfConfig::get('app_couchdb_database');?>/<?php echo $document->_id; ?>">Admin</a>
  </div>
  <div class="download">
  <?php // echo link_to('Télécharger au format juricaf', '@arretxml?id='.$document->_id); ?>
  </div>
  <?php
///// METAS /////
// CLASSIQUES //
$sf_response->setTitle($document->titre.' - Juricaf');
if(!empty($analyses)) {
  $sf_response->addMeta('Description', strip_tags(str_replace('</blockquote>', " ", $analyses)));
}
elseif (!empty($document->texte_arret)) {
  $sf_response->addMeta('Description', truncate_text(strip_tags(str_replace("\n", " ", trim($document->texte_arret))), 260));
}
if(!empty($keywords)) {
$sf_response->addMeta('Keywords', $keywords);
}
?>
