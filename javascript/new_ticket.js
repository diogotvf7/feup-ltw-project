
window.onload = function() {
    MultiSelectTag('tags');
}

async function MultiSelectTag (el, customs = {shadow: false, rounded:true}) {
    var element = null
    var options = null
    var customSelectContainer = null
    var wrapper = null
    var btnContainer = null
    var body = null
    var inputContainer = null
    var inputBody = null
    var input = null
    var button = null
    var drawer = null
    var ul = null
    var domParser = new DOMParser()
    await init()

    async function init()  {
        element = document.getElementById(el)
        await createElements()
        await initOptions()
        enableItemSelection()
        setValues()

        button.addEventListener('click', () => {
            if(drawer.classList.contains('hidden')) {
                initOptions()
                enableItemSelection()
                drawer.classList.remove('hidden')
                input.focus()
            }
        })

        input.addEventListener('keyup', (e) => {
                initOptions(e.target.value)
                enableItemSelection()
        })

        input.addEventListener('keydown', (e) => {
            if(e.key === 'Backspace' && !e.target.value && inputContainer.childElementCount > 1) {
                const child = body.children[inputContainer.childElementCount - 2].firstChild
                const option = options.find((op) => op.value == child.dataset.value)
                option.selected = false
                removeTag(child.dataset.value)
                setValues()
            }
            
        })
        
        window.addEventListener('click', (e) => {   
            if (!customSelectContainer.contains(e.target)){
                drawer.classList.add('hidden')
            }
        });
        

    }

    function addOption(option) {
        var newOption = document.createElement('option');
        newOption.value = option.value;
        newOption.label = option.label;
        newOption.selected = option.selected;
        element.appendChild(newOption);
      }
    function removeOption(option) {
        option = element.querySelector('option[value="' + option.value + '"]');
        element.removeChild(option);
        options = options.filter(op => op.value !== option.value);
    }

    async function createElements() {
        options = await getOptions();
        element.classList.add('hidden')
        
        customSelectContainer = document.createElement('div')
        customSelectContainer.classList.add('mult-select-tag')

        wrapper = document.createElement('div')
        wrapper.classList.add('wrapper')

        body = document.createElement('div')
        body.classList.add('body')
        if(customs.shadow) {
            body.classList.add('shadow')
        }
        if(customs.rounded) {
            body.classList.add('rounded')
        }
        
        inputContainer = document.createElement('div')
        inputContainer.classList.add('input-container')

        input = document.createElement('input')
        input.classList.add('input')
        input.placeholder = `${customs.placeholder || 'Search...'}`

        inputBody = document.createElement('inputBody')
        inputBody.classList.add('input-body')
        inputBody.append(input)

        body.append(inputContainer)

        btnContainer = document.createElement('div')
        btnContainer.classList.add('btn-container')

        button = document.createElement('button')
        button.type = 'button'
        btnContainer.append(button)

        const icon = domParser.parseFromString(`<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="18 15 12 21 6 15"></polyline></svg>`, 'image/svg+xml').documentElement
        button.append(icon)


        body.append(btnContainer)
        wrapper.append(body)

        drawer = document.createElement('div');
        drawer.classList.add(...['drawer', 'hidden'])
        if(customs.shadow) {
            drawer.classList.add('shadow')
        }
        if(customs.rounded) {
            drawer.classList.add('rounded')
        }
        drawer.append(inputBody)
        ul = document.createElement('ul');
        
        drawer.appendChild(ul)
    
        customSelectContainer.appendChild(wrapper)
        customSelectContainer.appendChild(drawer)

        if (element.nextSibling) {
            element.parentNode.insertBefore(customSelectContainer, element.nextSibling)
        }
        else {
            element.parentNode.appendChild(customSelectContainer);
        }
        
    }

    function initOptions(val = null) {
        ul.innerHTML = '';
        var optionFound = false;
        console.log("initOptions ->" , options);
        for (var option of options) {
            if (option.selected) {
                !isTagSelected(option.value) && createTag(option);
            } else {
                const li = document.createElement('li');
                li.innerHTML = option.label;
                li.dataset.value = option.value;
    
                if (val && option.label.toLowerCase().startsWith(val.toLowerCase())) {
                    ul.appendChild(li);
                    optionFound = true;
                } else if (!val) {
                    ul.appendChild(li);
                }
            }
        }
            if (val && !optionFound) {
            const newOption = {
                value: val,
                label: val,
                selected: false,
                default: false
            };
            const li = document.createElement('li');
            li.innerHTML = newOption.label;
            li.dataset.value = newOption.value; 
            ul.appendChild(li);
        }
    }

    function createTag(option) {
        const itemDiv = document.createElement('div');
        itemDiv.classList.add('item-container');
        const itemLabel = document.createElement('div');
        itemLabel.classList.add('item-label');
        itemLabel.innerHTML = option.label
        itemLabel.dataset.value = option.value
        const itemClose = new DOMParser().parseFromString(`<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="item-close-svg">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>`, 'image/svg+xml').documentElement
 
        itemClose.addEventListener('click', (e) => {
            const unselectOption = options.find((op) => op.value == option.value)
            unselectOption.selected = false
            removeTag(option.value)
            initOptions()
            setValues()
        })
        
        itemDiv.appendChild(itemLabel)
        itemDiv.appendChild(itemClose)
        inputContainer.append(itemDiv)
    }

    function enableItemSelection() {
        for(var li of ul.children) {
            li.addEventListener('click', (e) => {
                var option = options.find((o) => o.value == e.target.dataset.value);
                if (!option) {
                    newOption = {
                        value: e.target.dataset.value,
                        label: e.target.innerHTML,
                        selected: true,
                        default : false
                    };
                    createTag(newOption);
                    options.push(newOption);
                    addOption(newOption);

                    
                } else {
                    option.selected = true;
                }
                input.value = null;
                initOptions();
                setValues();
                input.focus();
            })
        }
    }

    function isTagSelected(val) {
        for(var child of inputContainer.children) {
            if(!child.classList.contains('input-body') && child.firstChild.dataset.value == val) {
                return true
            }
        }
        return false
    }
    function removeTag(val) {
        for(var child of inputContainer.children) {
            if(!child.classList.contains('input-body') && child.firstChild.dataset.value == val) {
                inputContainer.removeChild(child);
                if (options.find((op) => op.value == val).default === false){
                    removeOption(options.find((op) => op.value == val))
                }

            }
        }
    }
    function setValues() {
        console.log("setValues -> options", options);
        console.log("setValues -> element.options", element.options);
        for(var i = 0; i < options.length; i++) {
            element.options[i].selected = options[i].selected
     
    }
} 

async function fetchTags() {
    const response = await fetch('../pages/api_tag.php?' + encodeForAjax({
        func: 'tags',
    }));
    const tags = await response.json();
    return tags;
}

    async function getOptions() {
        
        const tagsSelect = document.getElementById('tags');
        const tags = await fetchTags();
        console.log("tags" , tags);

        options = Array.from(tags).map((option) => ({
            value: option.Name,
            label: option.Name,
            selected: false,
            default: true,
        }));
        console.log(options);
        for (var i = 0; i < options.length; i++){
            addOption(options[i]);
        }
        return options;
}

function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
        if (data[k] === null || data[k] === undefined) return;
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&')
}
}