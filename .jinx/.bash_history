git clone https://github.com/VundleVim/Vundle.vim.git ~/.vim/bundle/Vundle.vim
udo apt-get update
sudo apt-get install tmux
git clone https://github.com/tmux-plugins/tpm ~/.tmux/plugins/tpm
git clone https://github.com/VundleVim/Vundle.vim.git ~/.vim/bundle/Vundle.vim
it clone https://github.com/tmux-plugins/tpm ~/.tmux/plugins/tpm
exit
tmux
tmux attach
vi ~/.tmux.conf
echo "run-shell ~/.tmux/tmux-ticker/ticker.tmux" >> ~/.tmux.conf
awk '/^$/{print;print "set -g @ticker_stock \"AAPL\"\n#{ticker_stock}\n# Replace the name with the stock you would like to track.\nset -g @ticker_stock \"AAPL\"\n# You can also set styles for the ticker_stock based on stock movement direction\nset -g @ticker_positive_style  \"#[fg=#A7C080, bg=#414550]\"\nset -g @ticker_negative_style  \"#[fg=#FF4858, bg=#414550]\"\n# Then use it in your status line\nset -g status-left \"......#[fg=#21252D,bg=#5AD1AA] #{ticker_nasdaq} ~ #{ticker_stock} ~ #{ticker_stock_change} \";next}1' ~/.tmux.conf > temp && mv temp ~/.tmux.conf
vi ~/.tmux.conf
esit
exit
ls
vi index.html
exit
xit
exit
cat ~/.jinx.txt
cp ~/.vimrc ~/.jinxrc
cat ~/.jinxrc 
sed -i '/CalculateSMA/,/endfunction/d' ~/.vimrc
cat ~/.vimrc
diff ~/.vimrc ~/.jinxrc
diff ~/.vimrc ~/.jinxrc | more
vi ~/.vimrc
mv /home/codespace/.symfony5/bin/symfony /usr/local/bin/symfony
sudo mv /home/codespace/.symfony5/bin/symfony /usr/local/bin/symfony
symfony new -h
symfony new --webapp --docker --cloud
ls
vi ~/.vimrc
cat << EOF >> ~/.bashrc
function update_printlines() {
    sed -i '/function! PrintLines()/,/endfunction/d' ~/.vimrc
    cat << EOM >> ~/.vimrc
function! PrintLines()
    let last_line = system('tail -n 1 ~/.jinx.txt')
    let line_20 = system('tail -n 21 ~/.jinx.txt | head -n 1')
    let last_yesterday = system('grep "$(date -d \'yesterday\' \'+%Y-%m-%d\')" ~/.jinx.txt | tail -n 1')
    let first_today = system('grep "$(date \'+%Y-%m-%d\')" ~/.jinx.txt | head -n 1')
    if !empty(last_line)
        echo "Last: " . last_line
    endif
    if !empty(line_20)
        echo "20th: " . line_20
    endif
    if !empty(last_yesterday)
        echo "Yesterday: " . last_yesterday
    endif
    if !empty(first_today)
        echo "Today: " . first_today
    endif
endfunction
EOM
}
EOF

source ~/.bashrc
vi ~/.bashrc
php index.php 
sed -i '/statusline/d' ~/.vimrc
vi ~/.vimrc
exit
tmux source ~/.tmux.conf
[A
tmux source ~/.tmux.conf
exit
source ~/.bashrc
exit
open_config_files 
exit
:qq
:q
exit
open_config_files 
exit
source ~/.bashrc
open_config_files 
exit
vi source ~/.vimrc
vi '~/.vimrc
vi ~/.vimrc
source ~/.bashrc
OpenTerminalStayCurrent
exit
ls ~/.tmux/tmux-ticker/scripts/exit
exit
node
sqlite3
exit
jobs
exit
xit
exit
source ~/.bashrc
exit
source ~/.vimrc
exit
npm install -g npm@10.4.0
exit
cat <<EOF >> ~/.bashrc
function edit_files() {
    vi -O /path/to/first/file /path/to/second/file
}
EOF

source ~/.bashrc
cat <<EOF >> ~/.bashrc
function! OpenTerminal()
    if !exists('t:terminal_bufnr') || bufexists(t:terminal_bufnr) == 0
        botright new
        setlocal buftype=nofile bufhidden=wipe nobuflisted
        terminal
        let t:terminal_bufnr = bufnr('%')
    endif
endfunction

command! OpenTerminal call OpenTerminal()
EOF

cat <<EOF >> ~/.vimrc
function! OpenTerminal()
    if !exists('t:terminal_bufnr') || bufexists(t:terminal_bufnr) == 0
        botright new
        setlocal buftype=nofile bufhidden=wipe nobuflisted
        terminal
        let t:terminal_bufnr = bufnr('%')
    endif
endfunction

command! OpenTerminal call OpenTerminal()
EOF

cat <<EOF >> ~/.bashrc
function edit_configs() {
    vi -O ~/.bashrc ~/.vimrc
}
EOF

source ~/.bashrc
cat <<EOF >> ~/.bashrc
# Use fzf to select a file and preview it in vi

fzf-preview-vi() {
    local selected_file
    selected_file=$(fzf --preview 'bat --color "always" {}' --preview-window=right:50%:wrap)
    if [[ -n $selected_file ]]; then
        vi "$selected_file"
    fi
}
EOF

vi ~/.bashrc
vi -O ~/.bashrc ~/.vimrc
ls
ls ~
sudo apt install vim
sudo apt-get install -y libncurses5-dev libgnome2-dev libgnomeui-dev libgtk2.0-dev libatk1.0-dev libbonoboui2-dev libcairo2-dev libx11-dev libxpm-dev libxt-dev python-dev \
git clone https://github.com/vim/vim.git
git clone --depth 1 https://github.com/vim/vim.git
cd vim
git pull
cd src
make
sudo make install
vi
vim
jobs
cd ..
cp vim ~/
cp -r vim ~
printenv
printenv >> ~/.jinxenv
cat ~/.jinxenv | more
printenv $HOME
$HOME
echo ~
echo 'export PATH+=$PATH:$HOME/vim/src/vim' >> ~/.bashrc
source ~/.bashrc
vi
~/vim/src/vim
fg %
~/vim/src/vim -O ~/.vimrc ~/.bashrc
fg %
vi -O ~/.bashrc ~/.vimrc
v -O ~/.bashrc ~/.vimrc
vim -O ~/.bashrc ~/.vimrc
exit
jbos
jobs
exit
node
exit
source_last_updated 
tmux source-file ~/.tmux.conf
tmux source ~/.tmux.conf
exit
jobs
vim -O ~/.vimrc ~/.bashrc
exit
tmux
tmux attach
tmux
tmux new
fg %
exit
vi ~/.tmux.conf
vim ~/.tmux.conf
exit
tmux
exit
source ~/.bashrc
phps 8080
source ~/.bashrc
phps 8080
source ~/.bashrc
phps 8080
source ~/.bashrc
phps 8080
phps
php -S localhost:8080
exit
cat <<EOF >> ~/.bashrc
function phps() {
    options=("Start PHP server" "Kill a port" "View all ports in use")
    command=$(printf '%s\n' "${options[@]}" | fzf --preview-window up:3 --preview 'case {} in 
        "Start PHP server") read -p "Enter port: " port; echo "php -S localhost:$port";;
        "Kill a port") read -p "Enter port to kill: " port; echo "kill $(lsof -t -i:$port)";;
        "View all ports in use") echo "lsof -i";;
        *) echo "Invalid option";;
    esac')

    eval "$command"
}
EOF

cat << EOF >> ~/.bashrc
function phps() {
    options=("Start PHP server" "Kill a port" "View all ports in use")
    command=$(printf '%s\n' "${options[@]}" | fzf --preview-window up:3 --preview 'case {} in 
        "Start PHP server") read -p "Enter port: " port; echo "php -S localhost:$port";;
        "Kill a port") read -p "Enter port to kill: " port; echo "kill $(lsof -t -i:$port)";;
        "View all ports in use") echo "lsof -i";;
        *) echo "Invalid option";;
    esac')

    eval "$command"
}
EOF

vi ~/.bashrc
vim ~/.bashrc
exit
cd /workspaces/JinxFinance.github.io/
ls
php -S localhost:8004 information.php
bg %
php -S localhost:8004 index10.php
php -S localhost:8005 index10.php
bg %
jobs
php -S localhost:8012 index12.php
bg
jobs
bg %
fg
bg
# app.py
from flask import Flask, render_template
app = Flask(__name__)
@app.route('/')
def home():
@app.route('/about')
def about():
if __name__ == '__main__':
source ~/.bashrc
cat <<EOF >> ~/.bashrc
function phps() {
    read -p "Enter port: " port
    php -S localhost:$port
}
EOF

source ~/.bashrc
phps
exit
php -S localhost:8080 proxy.php & && php -S localhost:8079 index.php
php -S localhost:8080 proxy.php
bg %
php -S localhost:8406 index.php
bg %
jobs
bg %
jobs
fg %2
php -S localhost:8002 index.php
bg %
jobs
fg %1
php -S localhost:8081 index.php
bg %
jobs
ls
cd jinx
php -S localhost:8021
bg %
php -S localhost:8027 proxy.php
php -S localhost:8008
exit
ls
phps
mkdir jinx
:q
exit
phps
bg %
ls
cd ..
ls
cd ~
ls
cd /var/www/nearbystays.com/public_html/
ls
viindex.php
vi index.php
ls
vim index.php
exit
tmux
exit
