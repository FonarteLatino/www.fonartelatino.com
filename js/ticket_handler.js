// Manejador de tickets mejorado con compatibilidad cross-browser
const TicketHandler = {
    // Cache de tickets para evitar recargas innecesarias
    ticketCache: new Map(),
    
    // Cargar ticket
    loadTicket: function(idPedido) {
        return new Promise((resolve, reject) => {
            // Revisar caché primero
            if (this.ticketCache.has(idPedido)) {
                resolve(this.ticketCache.get(idPedido));
                return;
            }

            // Configurar el request
            const xhr = new XMLHttpRequest();
            xhr.open('GET', `ajax_contenido_ticket.php?id_pedido=${encodeURIComponent(idPedido)}`, true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            
            // Manejar timeout
            xhr.timeout = 10000; // 10 segundos
            
            xhr.onload = () => {
                if (xhr.status === 200) {
                    try {
                        // Intentar parsear como JSON primero
                        const response = JSON.parse(xhr.responseText);
                        if (!response.success) {
                            reject(new Error(response.message || 'Error al cargar el ticket'));
                            return;
                        }
                        this.ticketCache.set(idPedido, response);
                        resolve(response);
                    } catch (e) {
                        // Si no es JSON, es contenido HTML directo
                        const content = xhr.responseText;
                        this.ticketCache.set(idPedido, content);
                        resolve(content);
                    }
                } else {
                    reject(new Error(`Error ${xhr.status}: ${xhr.statusText}`));
                }
            };
            
            xhr.onerror = () => {
                reject(new Error('Error de red al cargar el ticket'));
            };
            
            xhr.ontimeout = () => {
                reject(new Error('Tiempo de espera agotado'));
            };
            
            xhr.send();
        });
    },
    
    // Mostrar ticket en modal
    showTicket: function(idPedido) {
        const modalContent = document.getElementById('contenido_ticket');
        if (!modalContent) {
            console.error('Elemento contenido_ticket no encontrado');
            return;
        }
        
        modalContent.innerHTML = '<div class="text-center"><i class="fa fa-spinner fa-spin fa-3x"></i><br>Cargando ticket...</div>';
        
        this.loadTicket(idPedido)
            .then(content => {
                if (typeof content === 'object') {
                    // Es una respuesta JSON
                    modalContent.innerHTML = this.formatTicketContent(content);
                } else {
                    // Es HTML directo
                    modalContent.innerHTML = content;
                }
            })
            .catch(error => {
                modalContent.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="fa fa-exclamation-circle"></i>
                        Error: ${error.message}
                        <br>
                        <button class="btn btn-sm btn-danger mt-2" onclick="TicketHandler.retryLoad('${idPedido}')">
                            <i class="fa fa-refresh"></i> Reintentar
                        </button>
                    </div>`;
            });
    },
    
    // Formatear contenido del ticket
    formatTicketContent: function(data) {
        // Implementar según el formato de respuesta JSON
        return `
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Ticket #${data.id_pedido}</h4>
            </div>
            <div class="modal-body">
                ${this.formatTicketDetails(data)}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                ${this.formatActionButtons(data)}
            </div>`;
    },
    
    // Formatear detalles del ticket
    formatTicketDetails: function(data) {
        // Implementar según los datos disponibles
        return `
            <div class="ticket-details">
                <!-- Detalles formateados del ticket -->
            </div>`;
    },
    
    // Formatear botones de acción
    formatActionButtons: function(data) {
        let buttons = '';
        if (data.canPrint) {
            buttons += `
                <button class="btn btn-primary" onclick="TicketHandler.printTicket('${data.id_pedido}')">
                    <i class="fa fa-print"></i> Imprimir
                </button>`;
        }
        return buttons;
    },
    
    // Imprimir ticket
    printTicket: function(idPedido) {
        this.loadTicket(idPedido)
            .then(content => {
                const printWindow = window.open('', '_blank');
                printWindow.document.write(`
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <title>Ticket #${idPedido}</title>
                        <link rel="stylesheet" href="css/bootstrap.min.css">
                        <style>
                            body { padding: 20px; }
                            @media print {
                                .no-print { display: none; }
                            }
                        </style>
                    </head>
                    <body>
                        <div class="container">
                            ${typeof content === 'object' ? this.formatTicketContent(content) : content}
                        </div>
                        <script>
                            window.onload = function() { window.print(); }
                        </script>
                    </body>
                    </html>
                `);
                printWindow.document.close();
            })
            .catch(error => {
                alert(`Error al preparar la impresión: ${error.message}`);
            });
    },
    
    // Reintentar carga
    retryLoad: function(idPedido) {
        this.ticketCache.delete(idPedido);
        this.showTicket(idPedido);
    }
};

// Inicializar manejadores de eventos cuando el documento esté listo
document.addEventListener('DOMContentLoaded', function() {
    // Interceptar clics en enlaces de tickets
    document.addEventListener('click', function(e) {
        const ticketLink = e.target.closest('[data-ticket-id]');
        if (ticketLink) {
            e.preventDefault();
            const idPedido = ticketLink.dataset.ticketId;
            TicketHandler.showTicket(idPedido);
        }
    });
});