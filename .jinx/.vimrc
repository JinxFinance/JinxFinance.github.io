set nocompatible              " be iMproved, required
filetype off                  " required

set tabstop=2       " The width of a hard tabstop
set shiftwidth=2    " The size of an 'indent'
set softtabstop=2   " If non-zero, the number of spaces that a <Tab> in the file counts for
set expandtab       " Use spaces instead of tabs
set mouse=a    " Enable mouse support
set number     " Enable line numbers
syntax enable

" set the runtime path to include Vundle and initialize
set rtp+=~/.vim/bundle/Vundle.vim
call vundle#begin()

" let Vundle manage Vundle, required
Plugin 'VundleVim/Vundle.vim'
Plugin 'tpope/vim-fugitive'
Plugin 'tpope/vim-surround'
Plugin 'tpope/vim-repeat'
Plugin 'tpope/vim-commentary'
Plugin 'tpope/vim-vinegar'
Plugin 'tpope/vim-unimpaired'
Plugin 'tpope/vim-speeddating'
Plugin 'tpope/vim-eunuch'
Plugin 'tpope/vim-abolish'
" Plugin 'vim-airline/vim-airline'
Plugin 'dense-analysis/ale'
Plugin 'jayli/vim-easycomplete'
" Plugin 'SirVer/utilsnips'
Plugin 'prettier/vim-prettier', { 'do': 'yarn install', 'for': ['javascript', 'typescript', 'css', 'less', 'scss', 'json', 'graphql', 'markdown', 'vue', 'yaml', 'html'] }
Plugin 'codota/tabnine-vim'
Plugin 'ycm-core/YouCompleteMe'

" All of your Plugins must be added before the following line
call vundle#end()            " required
filetype plugin indent on    " required

nnoremap ;; :tabe<SPACE>
nnoremap ;n :tabnext<CR>
nnoremap ;m :tabprevious<CR>
nnoremap ;, :b<SPACE>
nnoremap ;N :bn<CR>
nnoremap ;M :bp<CR>
nnoremap ;v :vs<SPACE>
nnoremap ;H :sp<SPACE>
nnoremap ;e :edit<CR>

nnoremap ;w :w<CR>
nnoremap ;y :!tmux source-file ~/.tmux.conf<CR><CR>
nnoremap ;r :res<CR>
nnoremap ;R :res +5<CR>
nnoremap ;d :res 0<CR>
nnoremap ;D :res -5<CR>
nnoremap ;W :vertical resize +5<CR>
nnoremap ;E :vertical resize -5<CR>
" nnoremap ;t :below term<CR>
nnoremap ;a :wincmd r<CR>

nnoremap ;s :w<CR>:so %<CR>
nnoremap ;T :w<CR>:! tmux source ~/tmux.conf<CR><CR><CR>
nnoremap ;B :w<CR>:! source ~/.bashrc<CR><CR><CR>
nnoremap ;b :w<CR>:! source ~/.bashrc && source_last_edited<CR>


function! FoldMore()
    let l:foldend = line('.') + winheight(0) / 4
    execute 'normal! '.l:foldend.'Gzf'
endfunction

function! RunCommandInTerminal()
    let current_file = expand('%:p')
    let command_to_run = 'source_last_updated ' . current_file
    let tmux_command = 'tmux send-keys -t 0 "' . command_to_run . '" C-m'
    execute 'silent !' . tmux_command
    redraw!
endfunction

nnoremap ;h <C-W>h
nnoremap ;j <C-W>j
nnoremap ;k <C-W>k
nnoremap ;l <C-W>l

function! FetchGoogleFinance(timer_id)
  new
  setlocal buftype=nofile bufhidden=wipe nobuflisted noswapfile nowrap
  call setline(1, systemlist('curl https://www.google.com/finance'))
endfunction

" autocmd VimEnter * let s:timer = timer_start(1000, 'FetchGoogleFinance', {'repeat': -1})

function! JinxFinance()
  let last_line_jinx = system('tail -n 1 ~/.jinx.txt | tr -d "\0"')
  let last_line_nasdaq = system('tail -n 1 ~/.nasdaq.txt | tr -d "\0"')
  " return strftime('%H:%M:%S') getcwd()
  return "TSLA: " . last_line_jinx . ", Nasdaq: " . last_line_nasdaq
endfunction

command! GetTslaData call GetTslaData()))

let g:statusline_state = 1

function! ToggleStatusline()
  if &laststatus == 2
    set laststatus=0
  else
    set laststatus=2
  endif
endfunction

nnoremap ;S :call ToggleStatusline()<CR>)

function! JinxToggleStatusline()
    if g:statusline_state == 0
				set statusline=\ %l,%v\ %p%%\ %L\ %=%{&ff}\ %Y\
        " set statusline=%F%m%r%h%w\ [FORMAT=%{&ff}]\ [TYPE=%Y]\ [POS=%l,%v][%p%%]\ [LEN=%L]
        let g:statusline_state = 1
    elseif g:statusline_state == 1
				set statusline=\ %{g:last_edited_lines[0]}\ %{g:last_edited_lines[1]}\ %{g:last_edited_lines[2]}\ %{g:last_edited_lines[3]}\ %{g:last_edited_lines[4]}\ %=%{LastCommand()}\ %=%f\
        let g:statusline_state = 0
    endif
endfunction

" Set the status line to display the results of the custom function
highlight StatusLine ctermfg=4 ctermbg=15
highlight StatusLineNC ctermfg=15 ctermbg=4
highlight LineNr ctermfg=4 ctermbg=none
highlight CursorLineNr ctermfg=white ctermbg=none
highlight TabLine ctermfg=4 ctermbg=15
highlight TabLineSel ctermfg=15 ctermbg=4
highlight TabLineFill ctermfg=white ctermbg=white

nnoremap ;f :call JinxToggleStatusline()<CR>

augroup StatuslineGroup
    autocmd!
    autocmd VimEnter,BufNewFile * call ToggleStatusline()
augroup END

set showtabline=2

" Define a function to generate the tabline
function! JinxTab()
    let s = ''
    for i in range(tabpagenr('$'))
        " Add a space between tabs
        let s .= ' '

        " Highlight the current tab
        if i + 1 == tabpagenr()
            let s .= '%#TabLineSel#'
        else
            let s .= '%#TabLine#'
        endif

        " Add the tab number and the name of the first buffer in the tab
        let s .= ' ' . (i + 1) . ' ' . bufname(tabpagebuflist(i + 1)[0])

        " End the highlight
        let s .= '%#TabLineFill#'
    endfor

    " Fill the rest of the line with the TabLineFill highlight
    let s .= '%='

    return s
endfunction

function! MyTabLine()
    let s = ''
    for i in range(tabpagenr('$'))
        let tab = i + 1
        let win = tabpagewinnr(tab)
        let buflist = tabpagebuflist(tab)
        let buf = buflist[win - 1]
        let file = fnamemodify(bufname(buf), ':t')
        let parent = fnamemodify(bufname(buf), ':p:h:t')
        let grandparent = fnamemodify(bufname(buf), ':p:h:h:t')
        let s .= '%' . tab . 'T' . (tab == tabpagenr() ? '%1*' : '%2*')
        let s .= ' ' . grandparent[:2] . '/' . parent[:2] . '/' . file . ' '
    endfor
    let s .= '%T%#TabLineFill#%='
    let s .= (tabpagenr('$') > 1 ? '%999XX' : 'X')
    return s
endfunction

set tabline=%!MyTabLine()

" Set the tabline option to use the custom tabline
" set tabline=%!JinxTab()

set paste
set pastetoggle=;A
set showmatch
let loaded_matchparen = 1

function! YankMatchingWord(line, pattern)

  " Go to the specified line
  execute a:line

  " Replace * with .* to create a regex pattern
  let regex = substitute(a:pattern, '\*', '.*', 'g')

  " Search for the pattern on the line
  let line_text = getline('.')
  let matches = matchlist(line_text, '\<'.regex.'\>')

  " If a match was found, yank it
  if len(matches) > 0
    normal! "ayiw
  endif
endfunction
" Map the function to a key combination in visual mode
vnoremap ;' :call YankMatchingWord()<CR>


" Map the function to a key combination in visual mode
vnoremap ;' :call YankMatchingWord()<CR>

" Enable linting
let g:ale_lint_on_save = 1
let g:ale_lint_on_text_changed = 'never'

" Enable fixing
let g:ale_fix_on_save = 1

" Specify linters
let g:ale_linters = {
\   'python': ['flake8', 'mypy'],
\   'javascript': ['eslint'],
\}

" Specify fixers
let g:ale_fixers = {
\   '*': ['remove_trailing_lines', 'trim_whitespace'],
\   'javascript': ['prettier', 'eslint'],
\   'python': ['autopep8', 'isort'],
\}

" let g:airline#extensions#ale#enabled = 1

" inoremap ( ()<Left>
" inoremap [ []<Left>
" inoremap { {}<Left>
" inoremap <expr> <CR> getline('.')[col('.') - 2 : col('.') - 1] == '()' ?  '<CR><CR><Up><Tab>' : '<CR>'

function! YankMultipleTimes(line, col, times)
  " Save the current cursor position
  let l:save_cursor = getcurpos()

  " Move to the specified line and column
  call cursor(a:line, a:col)

  " Yank the specified number of times
  execute "normal " . a:times . "yy"

  " Restore the cursor position
  call setpos('.', l:save_cursor)
endfunction

" command! -nargs=3 YankMultipleTimes call YankMultipleTimes(<f-args><f-args><f-args>)

inoremap ;' <Esc>:YankMultipleTimes(

function! ReindentSelection()
  normal! gv=
endfunction
vnoremap ;, :call ReindentSelection()<CR>

" Define a custom function
function! FormatLines()
  " Use the = command to auto-indent the selected lines
  normal! gvgq
endfunction
"
" Map the function to a key combination in visual mode
" vnoremap ;, :call FormatLines()<CR>

function! MoveBufferToLeft()
    " Get the buffer number of the current buffer
    let l:bufnum = bufnr('%')

    " Move the current buffer to the far left
    execute 'bmove 1'

    " Switch to the buffer
    execute 'buffer' l:bufnum
endfunction

" Map a key to call the function
nnoremap <leader>L :call MoveBufferToLeft()<CR>

function! MoveUsedBufferToLeft()
    " Get the buffer number of the current buffer
    let l:bufnum = bufnr('%')

    " Go to the far left window
    wincmd H

    " Open the buffer in this window
    execute 'buffer' l:bufnum
endfunction

" Map a key to call the function
nnoremap <leader>B :call MoveBufferToLeft()<CR>

function! MoveBufferToLeft()
    " Get the buffer number of the current buffer
    let l:current_bufnum = bufnr('%')

    " Go to the far left window
    wincmd H

    " Get the buffer number of the far left buffer
    let l:left_bufnum = bufnr('%')

    " Go back to the original window
    wincmd p

    " Open the far left buffer in this window
    execute 'buffer' l:left_bufnum

    " Go to the far left window again
    wincmd H

    " Open the original buffer in this window
    execute 'buffer' l:current_bufnum
endfunction

" Map a key to call the function
nnoremap <leader>l :call MoveBufferToLeft()<CR>

function! SourceLastUpdated()
    !source_last_updated
endfunction

" Map a key to call the function
nnoremap <leader>s :call SourceLastUpdated()<CR>

command! -bang Tags call fzf#vim#tags('', fzf#vim#with_preview(), <bang>0)
" command! -bang Tags call fzf#vim#tags('', fzf#vim#with_preview('your-script {}'), <bang>0)

nnoremap ;o O<CR>

function! LastCommand()
    redir => command_history
    silent history :
    redir END
    return split(command_history, "\n")[-4]
endfunction

let g:last_edited_lines = repeat([0], 1000)

augroup LastEditedLines
    autocmd!
    autocmd TextChanged,TextChangedI * let g:last_edited_lines = [line('.'), g:last_edited_lines[0], g:last_edited_lines[1], g:last_edited_lines[2], g:last_edited_lines[3]]
augroup END

function! LastFiveCommands()
    redir => command_history
    silent history :
    redir END
    let command_lines = split(command_history, "\n")
    return join(command_lines[-6:-2], ', ')
endfunction

function! OpenTerminalStayCurrent()
    below terminal
    wincmd p
    vsplit ~/.vimrc
    execute 'normal! \<C-W>R'
    wincmd h
endfunction

command! OpenTerminalStayCurrent :call OpenTerminalStayCurrent()

function! OpenFilesAndSwitch()
    " Open the files
    execute "edit index.php"
    execute "split index.html"
    execute "vsplit index.css"
    execute "vsplit index.js"

endfunction

function! OpenTerminal()
    " Check if a terminal window exists
    windo if &buftype ==# 'terminal' | let s:term_exists = 1 | endif

    " If a terminal window exists, open a new terminal in the top left
    if exists('s:term_exists')
        topleft terminal
    " If no terminal window exists, open a new terminal in the bottom right
    else
        botright terminal
    endif

    " Unset the variable for the next call
    unlet! s:term_exists
endfunction

" Map the function to a key for easy access
nnoremap ;t :call OpenTerminal()<CR>

let g:ycm_python_binary_path = '~/python3.12'
