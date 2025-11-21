USE DB_FIFAAPP;

-- USUARIO DE EJEMPLO

CALL insertar_usuario("CORREO@EJEMPO.COM","NOMBRE EJEMPLO","APELLIDO EJEMPLO","CONTRASEÑA_EJEMPLO","https://url_de_ejemplo.com/foto.jpg");

CALL traer_datos_usuario("CORREO@EJEMPO.COM");

CALL editar_datos_usuario("CORREO@EJEMPO.COM","NOMBRE EJEMPLO EDITADO","APELLIDO EJEMPLO EDITADO","CONTRASEÑA_EJEMPLO_EDITADA","https://url_de_ejemplo.com/foto_editada.jpg");

select * from tabla_usuario;

-- ESTAMPASDE EJEMPLO

insert into tabla_estampa_jugador values
(
uuid(),
"http://192.168.100.13/BACKEND_PROCESAMIENTO_IMAGENES/img/paises/mexico.png",
"MEXICO",
"MEX",
"http://192.168.100.13/BACKEND_PROCESAMIENTO_IMAGENES/img/selecciones/mexicoSel.png",
"http://192.168.100.13/BACKEND_PROCESAMIENTO_IMAGENES/img/jugadores/raul_jimenez.png",
"MEXICO NATIONAL FOOTBALL TEAM",
"STRIKER (ST)",
"ST",
9,
"RAUL ALONSO JIMENEZ RODRIGUEZ",
"RAUL JIMENEZ",
"MAY 5, 1991 (34 YRS)",
"MAY 5, 1991, TEPEJIL DEL RIO, HIDALGO, MEXICO",
"6 FT 3 IN (1.90 M)",
"FULHAM (ENGLAND)",
"CLUB AMERICA (2011 - 2014)",
"OLYMPICS GAMES GOLD MEDAL 2012 (sub-23), CONCACAF GOLD CUP(2019, 2025), CONCACAF NATIONS LEAGUE (2025)"
);

insert into tabla_estampa_jugador values
(
uuid(),
"https://gapless-thirdly-jovita.ngrok-free.dev/BACKEND_PROCESAMIENTO_IMAGENES/img/paises/canada.png",
"CANADA",
"CAN",
"https://gapless-thirdly-jovita.ngrok-free.dev/BACKEND_PROCESAMIENTO_IMAGENES/img/selecciones/canadaSel.png",
"https://gapless-thirdly-jovita.ngrok-free.dev/BACKEND_PROCESAMIENTO_IMAGENES/img/jugadores/alphonso_davies.png",
"CANADA NATIONAL FOOTBALL TEAM",
"LEFT-BACK (LB)",
"LB",
19,
"ALPHONSO BOYLE DAVIES",
"ALPHONSO DAVIES",
"NOV 2, 2000 (25 YRS)",
"NOV 2, 2000, BUDUBURAM, GHANA",
"6 FT 0 IN (1.83 M)",
"BAYERN MUNICH (GERMANY)",
"VANCOUVER WHITECAPS FC (2016 - 2018)",
"CONCACAF PLAYER OF THE YEAR (2021, 2022, 2024), BUNDESLIGA CHAMPION (x5), UEFA CHAMPIONS LEAGUE (2020), FIFA CLUB WORLD CUP (2020)"
);

insert into tabla_estampa_jugador values
(
uuid(),
"https://gapless-thirdly-jovita.ngrok-free.dev/BACKEND_PROCESAMIENTO_IMAGENES/img/paises/usa.png",
"UNITED STATES",
"USA",
"https://gapless-thirdly-jovita.ngrok-free.dev/BACKEND_PROCESAMIENTO_IMAGENES/img/selecciones/usaSel.png",
"https://gapless-thirdly-jovita.ngrok-free.dev/BACKEND_PROCESAMIENTO_IMAGENES/img/jugadores/christian_pulisic.png",
"UNITED STATES NATIONAL FOOTBALL TEAM",
"WINGER (LW)",
"LW",
10,
"CHRISTIAN MATE PULISIC",
"CHRISTIAN PULISIC",
"SEP 18, 1998 (27 YRS)",
"SEP 18, 1998, HERSHEY, PENNSYLVANIA, USA",
"5 FT 10 IN (1.78 M)",
"AC MILAN (ITALY)",
"BORUSSIA DORTMUND (2016 - 2019)",
"CONCACAF NATIONS LEAGUE (2021, 2023, 2024), U.S. SOCCER MALE ATHLETE OF THE YEAR (x4), UEFA CHAMPIONS LEAGUE (2021), SERIE A PLAYER OF THE MONTH (DEC 2023)"
);

select * from tabla_estampa_jugador;

-- ALBUM DE EJEMPLO

CALL reclamar_estampa_usuario("9fde6c3c-b9ee-11f0-8c89-18c04d6599ee","CORREO@EJEMPO.COM");

CALL verificar_estampa_reclamada("9fde6c3c-b9ee-11f0-8c89-18c04d6599ee");

CALL traer_todas_estampas();

CALL listar_estampas_usuario("CORREO@EJEMPO.COM");

CALL eliminar_estampa_usuario("9fde6c3c-b9ee-11f0-8c89-18c04d6599ee","CORREO@EJEMPO.COM");

select * from tabla_estampas_usuario;

-- FAVORITOS DE EJEMPLO

CALL agregar_favoritos("9fde6c3c-b9ee-11f0-8c89-18c04d6599ee","CORREO@EJEMPO.COM");

CALL mostrar_favoritos_por_usuarios("CORREO@EJEMPO.COM");

CALL eliminar_favorito("9fde6c3c-b9ee-11f0-8c89-18c04d6599ee","CORREO@EJEMPO.COM");

-- TODOS LOS SELECT

select * from tabla_estampas_usuario;
select * from tabla_estampa_jugador;
select * from tabla_usuario;
select * from tabla_favorito;