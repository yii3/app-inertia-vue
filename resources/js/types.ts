export interface SharedPageProps {
    [key: string]: unknown
    app: {
        edition: string
        name: string
        repository: string
    }
}

export interface RuntimeSnapshot {
    framework: string
    php: string
    requestId: string
    servedAt: string
}

export interface RequestFeed {
    data: RequestFeedEvent[]
    page: number
    pages: number
    total: number
}

export interface RequestFeedEvent {
    accent: 'blue' | 'green' | 'orange'
    detail: string
    id: number
    layer: string
    title: string
}

export interface EcosystemDiagnostics {
    checks: string[]
    packages: number
    state: string
}
