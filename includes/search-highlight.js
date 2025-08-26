    const urlParams = new URLSearchParams(window.location.search);
    const highlightId = urlParams.get('highlight');

    if (highlightId) {
        const rowToHighlight = document.getElementById('row-id-' + highlightId);
        const logToHighlight = document.getElementById('log-id-' + highlightId);
        const membershipLogToHighlight = document.getElementById('mem-log-id-'+ highlightId);
        const customerSearchHighlight = document.getElementById('srch-log-' + highlightId)

        if (rowToHighlight) {
            rowToHighlight.classList.add('highlight-row');
            
            rowToHighlight.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        if(logToHighlight){
            logToHighlight.classList.add('highlight-log');
            
            logToHighlight.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        if(membershipLogToHighlight){
            membershipLogToHighlight.classList.add('mem-highlight-log');
            
            membershipLogToHighlight.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        if(customerSearchHighlight){
            customerSearchHighlight.classList.add('srch-highlight');
            
            customerSearchHighlight.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    document.addEventListener("click", () => {
        const HighlightedItem  = document.querySelectorAll('.highlight-row, .highlight-log, .mem-highlight-log, .srch-highlight');

        HighlightedItem.forEach(item => {
            item.classList.remove('highlight-row', 'highlight-log', 'mem-highlight-log', 'srch-highlight');
        });
    })
