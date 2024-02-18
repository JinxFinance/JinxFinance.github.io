# ~/.bashrc: executed by bash(1) for non-login shells.
# see /usr/share/doc/bash/examples/startup-files (in the package bash-doc)
# for examples

# If not running interactively, don't do anything
case $- in
    *i*) ;;
      *) return;;
esac

# don't put duplicate lines or lines starting with space in the history.
# See bash(1) for more options
HISTCONTROL=ignoreboth

# append to the history file, don't overwrite it
shopt -s histappend

# for setting history length see HISTSIZE and HISTFILESIZE in bash(1)
HISTSIZE=1000
HISTFILESIZE=2000

# check the window size after each command and, if necessary,
# update the values of LINES and COLUMNS.
shopt -s checkwinsize

# If set, the pattern "**" used in a pathname expansion context will
# match all files and zero or more directories and subdirectories.
#shopt -s globstar

# make less more friendly for non-text input files, see lesspipe(1)
[ -x /usr/bin/lesspipe ] && eval "$(SHELL=/bin/sh lesspipe)"

# set variable identifying the chroot you work in (used in the prompt below)
if [ -z "${debian_chroot:-}" ] && [ -r /etc/debian_chroot ]; then
    debian_chroot=$(cat /etc/debian_chroot)
fi

# set a fancy prompt (non-color, unless we know we "want" color)
case "$TERM" in
    xterm-color|*-256color) color_prompt=yes;;
esac

# uncomment for a colored prompt, if the terminal has the capability; turned
# off by default to not distract the user: the focus in a terminal window
# should be on the output of commands, not on the prompt
force_color_prompt=yes

if [ -n "$force_color_prompt" ]; then
    if [ -x /usr/bin/tput ] && tput setaf 1 >&/dev/null; then
	# We have color support; assume it's compliant with Ecma-48
	# (ISO/IEC-6429). (Lack of such support is extremely rare, and such
	# a case would tend to support setf rather than setaf.)
	color_prompt=yes
    else
	color_prompt=
    fi
fi

if [ "$color_prompt" = yes ]; then
    PS1='${debian_chroot:+($debian_chroot)}\[\033[01;32m\]\u@\h\[\033[00m\]:\[\033[01;34m\]\w\[\033[00m\]\$ '
else
    PS1='${debian_chroot:+($debian_chroot)}\u@\h:\w\$ '
fi
unset color_prompt force_color_prompt

# If this is an xterm set the title to user@host:dir
case "$TERM" in
xterm*|rxvt*)
    PS1="\[\e]0;${debian_chroot:+($debian_chroot)}\u@\h: \w\a\]$PS1"
    ;;
*)
    ;;
esac

# enable color support of ls and also add handy aliases
if [ -x /usr/bin/dircolors ]; then
    test -r ~/.dircolors && eval "$(dircolors -b ~/.dircolors)" || eval "$(dircolors -b)"
    alias ls='ls --color=auto'
    #alias dir='dir --color=auto'
    #alias vdir='vdir --color=auto'

    alias grep='grep --color=auto'
    alias fgrep='fgrep --color=auto'
    alias egrep='egrep --color=auto'
fi

# some more ls aliases
alias ll='ls -alF'
alias la='ls -A'
alias l='ls -CF'

# Add an "alert" alias for long running commands.  Use like so:
#   sleep 10; alert
alias alert='notify-send --urgency=low -i "$([ $? = 0 ] && echo terminal || echo error)" "$(history|tail -n1|sed -e '\''s/^\s*[0-9]\+\s*//;s/[;&|]\s*alert$//'\'')"'

# Alias definitions.
# You may want to put all your additions into a separate file like
# ~/.bash_aliases, instead of adding them here directly.
# See /usr/share/doc/bash-doc/examples in the bash-doc package.

if [ -f ~/.bash_aliases ]; then
    . ~/.bash_aliases
fi

# enable programmable completion features (you don't need to enable
# this, if it's already enabled in /etc/bash.bashrc and /etc/profile
# sources /etc/bash.bashrc).
if ! shopt -oq posix; then
  if [ -f /usr/share/bash-completion/bash_completion ]; then
    . /usr/share/bash-completion/bash_completion
  elif [ -f /etc/bash_completion ]; then
    . /etc/bash_completion
  fi
fi

# bash theme - partly inspired by https://github.com/ohmyzsh/ohmyzsh/blob/master/themes/robbyrussell.zsh-theme
__bash_prompt() {
    local userpart='`export XIT=$? \
        && [ ! -z "${GITHUB_USER}" ] && echo -n "\[\033[0;32m\]@${GITHUB_USER} " || echo -n "\[\033[0;32m\]\u " \
        && [ "$XIT" -ne "0" ] && echo -n "\[\033[1;31m\]➜" || echo -n "\[\033[0m\]➜"`'
    local gitbranch='`\
        if [ "$(git config --get devcontainers-theme.hide-status 2>/dev/null)" != 1 ] && [ "$(git config --get codespaces-theme.hide-status 2>/dev/null)" != 1 ]; then \
            export BRANCH=$(git --no-optional-locks symbolic-ref --short HEAD 2>/dev/null || git --no-optional-locks rev-parse --short HEAD 2>/dev/null); \
            if [ "${BRANCH}" != "" ]; then \
                echo -n "\[\033[0;36m\](\[\033[1;31m\]${BRANCH}" \
                && if [ "$(git config --get devcontainers-theme.show-dirty 2>/dev/null)" = 1 ] && \
                    git --no-optional-locks ls-files --error-unmatch -m --directory --no-empty-directory -o --exclude-standard ":/*" > /dev/null 2>&1; then \
                        echo -n " \[\033[1;33m\]✗"; \
                fi \
                && echo -n "\[\033[0;36m\]) "; \
            fi; \
        fi`'
    local lightblue='\[\033[1;34m\]'
    local removecolor='\[\033[0m\]'
    PS1="${userpart} ${lightblue}\w ${gitbranch}${removecolor}\$ "
    unset -f __bash_prompt
}
__bash_prompt
export PROMPT_DIRTRIM=4

update_vim() {
  if ! command -v vim &> /dev/null; then
    echo "Vim is not installed. Installing..."
    sudo apt install vim
  else
    echo "Updating Vim..."
    sudo apt update && sudo apt upgrade vim
  fi
}

source_last_updated() {
  # Get the last updated file
  last_updated_file=$(ls -t ~/.bashrc ~/.vimrc ~/.tmux.conf | head -n 1)

  # Source the last updated file
  case $last_updated_file in
    *b)
      echo "Sourcing .bashrc..."
      source ~/.bashrc &
      ;;
    *v)
      echo "Sourcing .vimrc..."
      # For .vimrc, we need to start a new Vim session
      source ~/.vim &
      ;;
    *t)
      echo "Sourcing .tmux.conf..."
      # For .tmux.conf, we need to source it in a running tmux session
      if [ -n "$TMUX" ]; then
        tmux source-file ~/.tmux.conf &
      else
        echo "No tmux session is running. Start a new session with 'tmux'."
      fi
      ;;
    esac
  }

bind -x '"\C-u": source_last_updated'
alias slu=source_last_updated

count_day_trades() {
  local trades=$1
  local holding_stock=false
  local day_trades=0

  for (( i=0; i<${#trades}; i++ )); do
    local trade=${trades:$i:1}
    if [[ $trade == "b" && $holding_stock == false ]]; then
      holding_stock=true
    elif [[ $trade == "s" && $holding_stock == true ]]; then
      day_trades=$((day_trades + 1))
      holding_stock=false
    fi
  done

  echo "Number of day trades: $day_trades"
}

function enable_trader() {
  PHP_INI=$(php --ini | grep "Loaded Configuration File" | sed -e "s|.*:\s*||")
  if ! grep -q "extension=trader.so" $PHP_INI; then
    echo "extension=trader.so" | sudo tee -a $PHP_INI > /dev/null
    echo "Trader extension enabled in $PHP_INI. Please restart your web server."
  else
    echo "Trader extension is already enabled in $PHP_INI."
  fi
}

default_package=""
function composer_require() {
  if [ "$1" = "." ]; then
    composer require "$default_package"
  else
    composer require "$1"
    default_package="${1%/*}"
  fi
}

function insert_eof() {
  local option=$1
  case $option in
    b) echo "cat << EOF >> ~/.bashrc" ;;
    v) echo "cat << EOF >> ~/.vimrc" ;;
    t) echo "cat << EOF >> ~/.tmux.conf" ;;
    p) echo "cat << EOF >> index.php" ;;
    o) echo "cat << EOF >> " ;;
    *) echo "Invalid option. Please use b for bashrc, v for vimrc, t for tmux.conf, or p for index.php." ;;
  esac
}
alias ic='insert_eof'

function end_eof() {
  echo -e "\nEOF"
}

# bind '"\C-i":"insert_eof"'

function update_php() {
    CURRENT_PHP_VERSION=$(php -v | head -n 1 | cut -d " " -f 2 | cut -f1-2 -d".")
    LATEST_PHP_VERSION=$(apt-cache madison php | head -n 1 | cut -d "|" -f 2 | tr -d " " | cut -f1-2 -d".")

    if [ "$CURRENT_PHP_VERSION" != "$LATEST_PHP_VERSION" ]; then
        sudo apt-get update
        sudo apt-get upgrade php
    fi
}

function install_php_trader() {
    if ! php -m | grep -q 'trader'; then
        pecl install trader
        echo "extension=trader.so" >> /etc/php/7.4/cli/php.ini
    fi
}

function install_symfony() {
    if ! command -v symfony &> /dev/null; then
        wget https://get.symfony.com/cli/installer -O - | bash
        export PATH="$HOME/.symfony/bin:$PATH"
    fi
}

# Run the function in the background and discard its output
function Jinx() {
  $1 > /dev/null 2>&1 &
  PID=$!
  wait $PID
  tmux display-message "$1 complete"
}

function jx() {
	Jinx install_symfony &
	Jinx update_php &
	Jinx update_vim &
	Jinx install_php_trader &
}
jx &

function print_lines() {
  file=~/.jinx.txt
  if [ -f "$file" ]; then
    last_line=$(tail -n 1 "$file")
    line_20=$(tail -n 21 "$file" | head -n 1)
    last_yesterday=$(grep "$(date -d 'yesterday' '+%Y-%m-%d')" "$file" | tail -n 1)
    first_today=$(grep "$(date '+%Y-%m-%d')" "$file" | head -n 1)
    echo "Last: $last_line, 20th: $line_20, Yesterday: $last_yesterday, Today: $first_today"
  else
    echo "File $file does not exist."
  fi
}

bind '"\C-x1": "cat <<EOF >> "'
bind '"\C-x2": "EOF"'
bind '"\C-xv": "~/.vimrc"'
bind '"\C-xb": "~/.bashrc"'
bind '"\C-xt": "~/.tmux.conf"'

# Define insert_*
insert_text() {
    local filename=
    local lineno=
    local text=
    sed -i "i" ""
}

# Bind the function to Control+x followed by 3
bind '"\C-x3": "echo insert_text filename lineno text\n"'

# Bind the sourcing of ~/.bashrc to Control+x followed by b
bind '"\C-x\C-B": "source ~/.bashrc\n"'

# Bind the sourcing of ~/.vimrc to Control+x followed by v
bind '"\C-x\C-V": "source ~/.vimrc\n"'

bind -x '"\C-xg": "git add . && git commit -m \"Jinx Data\" && git push"'

bind -x '"\C-xs": "source_latest"'

function source_latest() {
    # Get the most recently edited file
    latest_file=/home/codespace/.bashrc

    # Source the file
    if [[ $latest_file == *".bashrc" ]]; then
        source ~/.bashrc
        echo "Sourced ~/.bashrc"
    elif [[ $latest_file == *".vimrc" ]]; then
        source ~/.vimrc
        echo "Sourced ~/.vimrc"
    elif [[ $latest_file == *".tmux.conf" ]]; then
        tmux source-file ~/.tmux.conf
        echo "Sourced ~/.tmux.conf"
    fi
}

function list_php_trader_functions() {
    php -r '
     = get_extension_funcs("trader");
    foreach ( as ) {
        echo  . "\n";
    }
    '
}

function gitacp() {
    files=$1
    message=${2:-"jinx upload"}

    if [ "$files" = "." ]; then
        git add --all
    else
        git add $files
    fi

    git commit -m "$message"
    git push

    git status | fzf --preview 'echo {}'
}

[ -f ~/.fzf.bash ] && source ~/.fzf.bash
eval

function functions() {
	grep -A 10 "()" ~/.bashrc | fzf --preview "echo {}"
}

bind -x '"\C-xf": "functions"'

# Function to save data to SQLite database
save_to_db() {
    db_file=$1
    table_name=$2
    data=$3

    # Create table if it doesn't exist
    sqlite3 $db_file "CREATE TABLE IF NOT EXISTS $table_name (data TEXT);"

    # Insert data into table
    sqlite3 $db_file "INSERT INTO $table_name (data) VALUES ('$data');"
}

# Usage
# save_to_db "my_database.db" "my_table" "my_data"

retrieve_data() {
    db_file=$1
    table_name=$2

    # Retrieve data from database
    data=$(sqlite3 $db_file "SELECT * FROM $table_name")

    echo "$data"
}

# Usage
# retrieve_data "my_database.db" "my_table"

function open_config_files() {
  vim -c "edit ~/.bashrc | below terminal | execute 'normal! \<C-W>k' | vsplit ~/.vimrc | execute 'normal! \<C-W>R'"
}

function OpenTerminalStayCurrent() {
    vim -c "below terminal | execute 'normal! \<C-W>p' | vsplit ~/.vimrc | execute 'normal! \<C-W>R' | wincmd h"
}

function create_table() {
    sqlite3 my_database.db "CREATE TABLE my_table (price REAL, datetime TEXT);"
}

function insert_data() {
    sqlite3 my_database.db "INSERT INTO my_table (price, datetime) VALUES ($1, '$2');"
}

function retrieve_data() {
    sqlite3 my_database.db "SELECT * FROM my_table;"
}

function update_data() {
    sqlite3 my_database.db "UPDATE my_table SET price = $1 WHERE datetime = '$2';"
}

function delete_data() {
    sqlite3 my_database.db "DELETE FROM my_table WHERE datetime = '$1';"
}

function retrieve_specific_data() {
    sqlite3 my_database.db "SELECT * FROM my_table WHERE price = $1;"
}

function crud_operation() {
    php ~/index.php $1 $2 $3
}
function edit_configs() {
    vi -O ~/.bashrc ~/.vimrc
}
export PATH+=$PATH:$HOME/vim/src/vim
alias v='~/vim/src/vim'

function toggle_tmux_status() {
    # Get the current status line
    local status=$(tmux show-option -gqv status-left)

    # Set the new status line based on the current status line
    if [[ $status == "Status1" ]]; then
        tmux set-option -g status-left "Status2"
				set -g status-left " #(TZ='America/Los_Angeles' date '+%A') #{ticker_dji} #{ticker_dji_change} "
    elif [[ $status == "Status2" ]]; then
        tmux set-option -g status-left " #(TZ='America/Los_Angeles' date '+%A') #{ticker_crypto} #{ticker_crypto_change} "
    else
        tmux set-option -g status-left " #(TZ='America/Los_Angeles' date '+%A') #{ticker_stock} ~ #{ticker_stock_change}"
    fi
}

function phps() {
    if [ -z "$1" ]
    then
        echo "Please specify a host."
        php -S localhost:8000
    else
        php -S localhost:$1
    fi
}
function phps() {
    read -p "Enter port: " port
    php -S localhost:
}

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
