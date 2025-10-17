{{--
/**
 * 소셜 프로필 관리 페이지
 *
 * 사용자가 자신의 소셜 미디어 계정 정보를 관리할 수 있는 페이지입니다.
 * Twitter, GitHub, Instagram, LinkedIn, YouTube 등의 프로필 링크를
 * 추가하거나 수정할 수 있습니다.
 *
 * 사용되는 변수:
 * @var $socialProfile - 사용자의 기존 소셜 프로필 정보 (UserSocial 모델)
 *
 * 기능:
 * - 소셜 미디어 계정 정보 표시 및 수정
 * - 폼 유효성 검사 및 에러 메시지 표시
 * - 성공 메시지 표시
 *
 * @package Jiny\Auth\Social
 * @author Jiny Framework Team
 * @since 1.0.0
 */
--}}

@extends('jiny-admin::layouts.home')

@section('title', '소셜 프로필')

{{-- 페이지별 JavaScript 파일 로드 --}}
@push('scripts')
    <script src="{{ asset('assets/js/vendors/validation.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/navbar-nav.js') }}"></script>
@endpush

@section('content')
    <div class="container mb-4">
        {{-- 페이지 제목 --}}
        <div class="row mb-5">
          <div class="col-12">
            <h1 class="h2 mb-0">소셜 프로필</h1>
          </div>
        </div>

        {{-- 성공 메시지 표시 --}}
        @if(session('success'))
        <div class="row mb-3">
          <div class="col-12">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          </div>
        </div>
        @endif

        <div class="row">
          <div class="col-12">
            {{-- 소셜 프로필 관리 카드 --}}
            <div class="card">
              {{-- 카드 헤더 --}}
              <div class="card-header">
                <h3 class="mb-0">Social Profiles</h3>
                <p class="mb-0">Add your social profile links in below social accounts.</p>
              </div>

              {{-- 카드 본문 - 소셜 프로필 폼 --}}
              <div class="card-body">
                <form action="{{ route('home.account.social.update') }}" method="POST">
                  @csrf

                  {{-- Twitter 프로필 입력 --}}
                  <div class="row mb-5">
                    <div class="col-lg-3 col-md-4 col-12">
                      <h5>Twitter</h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-12">
                      <input type="text" name="twitter" class="form-control mb-1"
                             placeholder="Twitter Profile Name"
                             value="{{ old('twitter', $socialProfile->twitter ?? '') }}" />
                      <small>Add your Twitter username (e.g. johnsmith).</small>
                      @error('twitter')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>

                  {{-- GitHub 프로필 입력 --}}
                  <div class="row mb-5">
                    <div class="col-lg-3 col-md-4 col-12">
                      <h5>GitHub</h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-12">
                      <input type="text" name="github" class="form-control mb-1"
                             placeholder="GitHub Profile Name"
                             value="{{ old('github', $socialProfile->github ?? '') }}" />
                      <small>Add your GitHub username (e.g. johnsmith).</small>
                      @error('github')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>

                  {{-- Instagram 프로필 입력 --}}
                  <div class="row mb-5">
                    <div class="col-lg-3 col-md-4 col-12">
                      <h5>Instagram</h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-12">
                      <label class="form-label visually-hidden" for="socialProfileInstagram">Instagram</label>
                      <input type="text" name="instagram" class="form-control mb-1"
                             placeholder="Instagram Profile Name"
                             id="socialProfileInstagram"
                             value="{{ old('instagram', $socialProfile->instagram ?? '') }}" />
                      <small>Add your Instagram username (e.g. johnsmith).</small>
                      @error('instagram')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>

                  {{-- LinkedIn 프로필 입력 --}}
                  <div class="row mb-5">
                    <div class="col-lg-3 col-md-4 col-12">
                      <h5>LinkedIn Profile URL</h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-12">
                      <label class="form-label visually-hidden" for="socialProfileLinkedin">LinkedIn Profile</label>
                      <input type="text" name="linkedin" class="form-control mb-1"
                             placeholder="LinkedIn Profile URL"
                             id="socialProfileLinkedin"
                             value="{{ old('linkedin', $socialProfile->linkedin ?? '') }}" />
                      <small>Add your linkedin profile URL. (https://www.linkedin.com/in/username)</small>
                      @error('linkedin')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>

                  {{-- YouTube 프로필 입력 --}}
                  <div class="row mb-3">
                    <div class="col-lg-3 col-md-4 col-12">
                      <h5>YouTube</h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-12">
                      <label class="form-label visually-hidden" for="socialProfileYoutube">YouTube</label>
                      <input type="text" name="youtube" class="form-control mb-1"
                             placeholder="YouTube URL"
                             id="socialProfileYoutube"
                             value="{{ old('youtube', $socialProfile->youtube ?? '') }}" />
                      <small>Add your Youtube profile URL.</small>
                      @error('youtube')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>

                  {{-- 저장 버튼 --}}
                  <div class="row">
                    <div class="offset-lg-3 col-lg-6 col-12">
                      <button type="submit" class="btn btn-primary">Save Social Profile</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
    </div>
@endsection