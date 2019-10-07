/* IE11 대응 폴리필 추가, 프로미스 추가 : 최상단에 위치해야 함 */
import 'babel-polyfill'
import 'es6-promise/auto'

import EditorJS from '@editorjs/editorjs'

import CodeTool from '@editorjs/code'
import Header from '@editorjs/header'
import List from '@editorjs/list'
import Marker from '@editorjs/marker'
import Paragraph from '@editorjs/paragraph'
import Quote from '@editorjs/quote'
import Table from '@editorjs/table'