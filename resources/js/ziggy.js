    var Ziggy = {
        namedRoutes: {"api.projects.index":{"uri":"api\/projects","methods":["GET","HEAD"],"domain":null},"api.projects.store":{"uri":"api\/projects","methods":["POST"],"domain":null},"api.activities.index":{"uri":"api\/activities","methods":["GET","HEAD"],"domain":null},"api.activities.store":{"uri":"api\/activities","methods":["POST"],"domain":null},"api.times.store":{"uri":"api\/times","methods":["POST"],"domain":null},"api.times.update":{"uri":"api\/times\/{time}","methods":["POST"],"domain":null},"api.times.destroy":{"uri":"api\/times\/{time}","methods":["DELETE"],"domain":null},"api.users.store":{"uri":"api\/users","methods":["POST"],"domain":null},"api.timezones.index":{"uri":"api\/timezones","methods":["GET","HEAD"],"domain":null}},
        baseUrl: 'https://tracker.straube.co/',
        baseProtocol: 'https',
        baseDomain: 'tracker.straube.co',
        basePort: false,
        defaultParameters: []
    };

    if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
        for (var name in window.Ziggy.namedRoutes) {
            Ziggy.namedRoutes[name] = window.Ziggy.namedRoutes[name];
        }
    }

    export {
        Ziggy
    }
