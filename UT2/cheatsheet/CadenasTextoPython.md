🐍 Chuleta de Cadenas de Texto en Python
🔤 Concepto Básico

Las cadenas de texto (strings) son secuencias de caracteres en Unicode.
Permiten representar texto, símbolos y emojis 😎.

Ejemplo:
'Hola, mundo' o "Hola, mundo"

🧱 Crear Strings

Comillas simples → 'texto'

Comillas dobles → "texto"

Comillas triples → """texto multilínea"""

💡 Usa triples comillas dobles para docstrings (PEP 257)

🚫 Cadena Vacía

'' → cadena sin caracteres

🔄 Conversión de Tipos

str(10) → '10'
int('10') → 10
float('3.14') → 3.14

🧩 Secuencias de Escape
Secuencia	Significado
\n	Salto de línea
\t	Tabulación
'	Comilla simple
\	Barra invertida
🧱 Raw Strings

Evita procesar caracteres especiales.
r'a\tb\tc' → muestra literalmente a\tb\tc

🖨️ Función print()

print(a, b, sep='|', end='!!')

⌨️ Entrada por Teclado

name = input('Tu nombre: ')

⚠️ No uses “input” como nombre de variable.

➕ Operaciones con Strings

Concatenar: 'Hola ' + 'Mundo'
Repetir: 'Hi! ' * 3 → Hi! Hi! Hi!

🔢 Índices y Slicing

'Python'[0] → 'P'
'Python'[-1] → 'n'
'Python'[0:3] → 'Pyt'

📏 Longitud

len('Hola') → 4

🔍 Buscar dentro de una Cadena

'sol' in 'girasol' → True
texto.startswith('Hola')
texto.endswith('fin')
texto.find('a') / texto.index('a')
texto.count('a')

🧼 Limpiar Texto

strip() → elimina espacios, \n, \t
lstrip(), rstrip() → izquierda / derecha

🔁 Reemplazar

'mal'.replace('m', 'b') → 'bal'

🔠 Mayúsculas / Minúsculas
Método	Efecto
capitalize()	Primera mayúscula
title()	Cada palabra mayúscula
upper()	Todo mayúsculas
lower()	Todo minúsculas
swapcase()	Invierte mayús/minús
🔎 Identificación de Caracteres
Método	Devuelve True si...
isalpha()	Solo letras
isdigit()	Solo números
isalnum()	Letras o números
isupper()	Todo mayúsculas
islower()	Todo minúsculas
🧮 Interpolación (f-strings)

f'Me llamo {name} y tengo {age} años'

✨ Formatear:

f'{pi:.2f}' → 2 decimales

f'{n:05d}' → relleno con ceros

f'{valor:x}' → hexadecimal

🧠 Modo debug:
f'{var=}' → muestra var=valor

🚀 Unicode

'\N{ROCKET}' → 🚀
ord('A') → 65
chr(65) → 'A'

🔡 Comparar Cadenas

Compara carácter a carácter (lexicográficamente):
'a' < 'b', 'A' < 'a'

✅ Resumen Express
Acción	Ejemplo
Concatenar	'Hola' + '!'
Repetir	'Hi! ' * 3
Longitud	len(texto)
Buscar	'a' in texto
Limpiar	texto.strip()
Mayúsculas	texto.upper()
Interpolar	f'{var}'

📘 Recuerda:
Los strings son inmutables → no se pueden modificar, solo crear nuevos.
