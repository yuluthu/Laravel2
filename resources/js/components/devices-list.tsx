import {cn} from '@/lib/utils';
import DeviceCard from './device-card';
import {useQuery} from '@tanstack/react-query'
import { Form, Head, Link, usePage } from '@inertiajs/react';
import { useHttp } from '@inertiajs/react'
import { useState, useEffect } from 'react';

async function getDevices() {
    const response = await fetch('/api/v1/devices');
    if (!response.ok) throw new Error(`Failed to fetch: ${response.status}`);
    console.log(response.json())
    return response.json();
}

export default function DeviceList() {
    const {data, setData, get, processing } = useHttp({
        devices: [],
    })

    useEffect(() => {
        get('/api/v1/devices', {
            onSuccess: (response) => {
                //  response.data;
                setData(response)
            },
        })
    }, []);
    
    return (
        <div className="flex flex-wrap gap-4">
            {data?.length > 0 ? 
                data.map((device: any) => (
                    <DeviceCard device={device} />
                )
            ) : (
                <span>No devices found</span>
            )
            }
        </div>
    )
}