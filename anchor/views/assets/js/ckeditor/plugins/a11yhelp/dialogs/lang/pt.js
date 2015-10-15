﻿/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.plugins.setLang( 'a11yhelp', 'pt', {
	title: 'Instruções de acessibilidade',
	contents: 'Conteúdo de ajuda. Use a tecla ESC para fechar esta janela.',
	legend: [
		{
		name: 'Geral',
		items: [
			{
			name: 'Barra de ferramentas do editor',
			legend: 'Clique em ${toolbarFocus} para navegar para a barra de ferramentas. Vá para o grupo da barra de ferramentas anterior e seguinte com TAB e SHIFT+TAB. Vá para o botão da barra de ferramentas anterior com a SETA DIREITA ou ESQUERDA. Pressione ESPAÇO ou ENTER para ativar o botão da barra de ferramentas.'
		},

			{
			name: 'Janela do Editor',
			legend:
				'Inside a dialog, press TAB to navigate to the next dialog element, press SHIFT+TAB to move to the previous dialog element, press ENTER to submit the dialog, press ESC to cancel the dialog. When a dialog has multiple tabs, the tab list can be reached either with ALT+F10 or with TAB as part of the dialog tabbing order. With tab list focused, move to the next and previous tab with RIGHT and LEFT ARROW, respectively.'  // MISSING
		},

			{
			name: 'Menu de Contexto do Editor',
			legend: 'Clique em ${contextMenu} ou TECLA APLICAÇÃO para abrir o menu de contexto. Depois vá para a opção do menu seguinte com TAB ou SETA PARA BAIXO. Vá para a opção anterior com  SHIFT+TAB ou SETA PARA CIMA. Pressione ESPAÇO ou ENTER para selecionar a opção do menu.  Abra o submenu da opção atual com ESPAÇO, ENTER ou SETA DIREITA. GVá para o item do menu parente  com ESC ou SETA ESQUERDA. Feche o menu de contexto com ESC.'
		},

			{
			name: 'Editor de caixa em lista',
			legend: 'Dentro da caixa da lista, vá para o itemda lista seguinte com TAB ou SETA PARA BAIXO. Move Vá parao item da lista anterior com SHIFT+TAB ou SETA PARA BAIXO. Pressione ESPAÇO ou ENTER para selecionar a opção da lista. Pressione ESC para fechar a caisa da lista.'
		},

			{
			name: 'Caminho Barra Elemento Editor',
			legend: 'Clique em ${elementsPathFocus} para navegar para a barra do caminho dos elementos. Vá para o botão do elemento seguinte com TAB ou SETA DIREITA. Vá para o botão anterior com SHIFT+TAB ou SETA ESQUERDA. Pressione ESPAÇO ou ENTER para selecionar o elemento no editor.'
		}
		]
	},
		{
		name: 'Comandos',
		items: [
			{
			name: 'Comando de Anular',
			legend: 'Carregar ${undo}'
		},
			{
			name: 'Comando de Refazer',
			legend: 'Pressione ${redo}'
		},
			{
			name: 'Comando de Negrito',
			legend: 'Pressione ${bold}'
		},
			{
			name: 'Comando de Itálico',
			legend: 'Pressione ${italic}'
		},
			{
			name: 'Comando de Sublinhado',
			legend: 'Pressione ${underline}'
		},
			{
			name: 'Comando de Hiperligação',
			legend: 'Pressione ${link}'
		},
			{
			name: 'Comando de Ocultar Barra de Ferramentas',
			legend: 'Pressione ${toolbarCollapse}'
		},
			{
			name: 'Acesso comando do espaço focus anterior',
			legend: 'Clique em ${accessPreviousSpace} para aceder ao espaço do focos inalcançável mais perto antes do sinal de omissão, por exemplo: dois elementos HR adjacentes. Repetir a combinação da chave para alcançar os espaços dos focos distantes.'
		},
			{
			name: 'Acesso comando do espaço focus seguinte',
			legend: 'Pressione ${accessNextSpace} para aceder ao espaço do focos inalcançável mais perto depois do sinal de omissão, por exemplo: dois elementos HR adjacentes. Repetir a combinação da chave para alcançar os espaços dos focos distantes.'
		},
			{
			name: 'Ajuda a acessibilidade',
			legend: 'Pressione ${a11yHelp}'
		}
		]
	}
	],
	backspace: 'Backspace', // MISSING
	tab: 'Tab', // MISSING
	enter: 'Enter', // MISSING
	shift: 'Shift',
	ctrl: 'Ctrl',
	alt: 'Alt',
	pause: 'Pausa',
	capslock: 'Maiúsculas',
	escape: 'Esc',
	pageUp: 'Page Up', // MISSING
	pageDown: 'Page Down', // MISSING
	end: 'Fim',
	home: 'Entrada',
	leftArrow: 'Seta esquerda',
	upArrow: 'Seta para cima',
	rightArrow: 'Seta direita',
	downArrow: 'Seta para baixo',
	insert: 'Inserir',
	'delete': 'Eliminar',
	leftWindowKey: 'Left Windows key', // MISSING
	rightWindowKey: 'Right Windows key', // MISSING
	selectKey: 'Select key', // MISSING
	numpad0: 'Numpad 0', // MISSING
	numpad1: 'Numpad 1', // MISSING
	numpad2: 'Numpad 2', // MISSING
	numpad3: 'Numpad 3', // MISSING
	numpad4: 'Numpad 4', // MISSING
	numpad5: 'Numpad 5', // MISSING
	numpad6: 'Numpad 6', // MISSING
	numpad7: 'Numpad 7', // MISSING
	numpad8: 'Numpad 8', // MISSING
	numpad9: 'Numpad 9', // MISSING
	multiply: 'Multiplicar',
	add: 'Adicionar',
	subtract: 'Subtrair',
	decimalPoint: 'Decimal Point', // MISSING
	divide: 'Divide', // MISSING
	f1: 'F1',
	f2: 'F2',
	f3: 'F3',
	f4: 'F4',
	f5: 'F5',
	f6: 'F6',
	f7: 'F7',
	f8: 'F8',
	f9: 'F9',
	f10: 'F10',
	f11: 'F11',
	f12: 'F12',
	numLock: 'Num Lock', // MISSING
	scrollLock: 'Scroll Lock', // MISSING
	semiColon: 'Semicolon', // MISSING
	equalSign: 'Equal Sign', // MISSING
	comma: 'Vírgula',
	dash: 'Dash', // MISSING
	period: 'Period', // MISSING
	forwardSlash: 'Forward Slash', // MISSING
	graveAccent: 'Acento grave',
	openBracket: 'Open Bracket', // MISSING
	backSlash: 'Backslash', // MISSING
	closeBracket: 'Close Bracket', // MISSING
	singleQuote: 'Single Quote' // MISSING
} );
